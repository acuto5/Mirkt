<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagArticlesIndexRequest;
use App\Tag;

class TagArticlesController extends Controller
{
    /**
     * Get tag articles
     *
     * @param \App\Http\Requests\Tags\TagArticlesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TagArticlesIndexRequest $request)
    {
        $tag = Tag::where(['name' => $request->get('tag_name')])->first();
    
        // Return only published articles
        $articles = $tag->articles()->published()->with('headerImage')->latest()->paginate(config('app.articles_per_page', 12));
    
        return response()->json($articles);
    }
}
