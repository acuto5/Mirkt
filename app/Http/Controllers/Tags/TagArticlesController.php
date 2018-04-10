<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tags\TagArticlesIndexRequest;
use App\Tag;

class TagArticlesController extends Controller
{
    const PER_PAGE = 10;
    
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
        $articles = $tag->articles()->published()->with('headerImage')->latest()->paginate(self::PER_PAGE);
    
        return response()->json($articles);
    }
}
