<?php

namespace App\Http\Controllers\Articles;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articles\PublishedArticlesIndexRequest;

class PublishedArticlesController extends Controller
{
    /**
     * Get all published articles
     *
     * @param \App\Http\Requests\Articles\ArticleShowRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PublishedArticlesIndexRequest $request)
    {
        $orderBy       = 'created_at';
        $with          = 'headerImage';
        $where         = [['is_draft', false]];
        $select        = ['id', 'title', 'sub_category_id', 'created_at'];
        $isDesc        = (isset($request->order_by) && $request->order_by === 'oldest') ? 'asc' : 'desc';
    
        // if sub_category_id selected
        if (isset($this->request->sub_category_id)) {
            $where[] = ['sub_category_id', $request->sub_category_id];
        }
    
        // Get article
        $articles = Article::select($select)
            ->where($where)
            ->with($with)
            ->orderBy($orderBy, $isDesc)
            ->paginate(env('ARTICLES_PER_PAGE', 12));
    
        return response()->json($articles);
    }
}
