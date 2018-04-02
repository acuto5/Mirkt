<?php

namespace App\Http\Controllers\Articles;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articles\ArticleDeleteRequest;
use App\Http\Requests\Articles\ArticleShowRequest;
use App\Http\Requests\Articles\ArticleStoreRequest;
use App\Http\Requests\Articles\ArticleUpdateRequest;
use App\Jobs\DeleteArticle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    const DELETE_AFTER_MINUTES = 15;
    
    /**
     * Get single article
     *
     * @param \App\Http\Requests\Articles\ArticleShowRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ArticleShowRequest $request): JsonResponse
    {
        $where = [
            ['id', $request->id],
        ];
        
        $select = [
            'id',
            'title',
            'content',
            'user_id',
            'is_draft',
            'sub_category_id',
            'created_at',
            'updated_at',
            'deletion_at',
        ];
        
        $with = [
            'author:id,name',
            'headerImage',
            'tags',
            'images',
            'subCategory' => function ($query) {
                $query->select('id', 'name', 'category_id')->with('category:id,name');
            },
        ];
        
        // If user isn`t blessed, allow only get from published articles
        if (Auth::guest() || (Auth::check() && !$request->user()->isBlessed())) {
            $where[] = ['is_draft', 0];
        }
        
        // Get article
        $article = Article::select($select)->where($where)->with($with)->first();
        
        // If article not found send 204 status code
        $responseCode = ($article === null) ? 204 : 200;
        
        return response()->json($article, $responseCode);
    }
    
    /**
     * Create new article
     *
     * @param \App\Http\Requests\Articles\ArticleStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleStoreRequest $request): JsonResponse
    {
        $article               = new Article();
        $additionalRequestData = [
            'user_id'     => Auth::id(),
            'deletion_at' => now()->addMinutes(self::DELETE_AFTER_MINUTES),
            'content'     => $request->get('content'),
        ];
    
        // Marge additional data with request
        $request->merge($additionalRequestData);
    
        // Create new Article
        $article->fill($request->all())->save();
    
        // Store and sync tags with article
        $article->syncTags($request->tags_ids);
    
        // Store and sync images with article
        $article->storeImages(
            $request->file('images'),
            (bool)$request->get('is_default_img_old'),
            (int)$request->get('default_image_id')
        );
    
        // Create job
        DeleteArticle::dispatch($article)->delay($request->get('deletion_at'));
    
        return response()->json($article->id);
    }
    
    /**
     * Update article
     *
     * @param \App\Http\Requests\Articles\ArticleUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleUpdateRequest $request): JsonResponse
    {
        $article = Article::find($request->id);
    
        // update fillable fields
        $article->update($request->except('deletion_at'));
    
        // Edit article tags
        $article->syncTags($request->tags_ids);
    
        // Sync old article images
        $article->syncOldImages(
            $request->get('old_images_ids'),
            (bool)$request->get('is_default_img_old'),
            (int)$request->get('default_image_id')
        );
    
        // Store and sync new images with article
        $article->storeImages(
            $request->file('images'),
            (bool)$request->get('is_default_img_old'),
            (int)$request->get('default_image_id')
        );
    
        return response()->json($article->id);
    }
    
    /**
     * Delete article
     *
     * @param \App\Http\Requests\Articles\ArticleDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(ArticleDeleteRequest $request): JsonResponse
    {
        Article::find($request->id)->forceDelete();
    
        return response()->json(true);
    }
}
