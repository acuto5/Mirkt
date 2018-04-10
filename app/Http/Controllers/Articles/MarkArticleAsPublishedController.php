<?php

namespace App\Http\Controllers\Articles;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articles\MarkArticleAsPublishedUpdateRequest;

class MarkArticleAsPublishedController extends Controller
{
    /**
     * Mark article as published
     *
     * @param \App\Http\Requests\Articles\MarkArticleAsPublishedUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MarkArticleAsPublishedUpdateRequest $request)
    {
        $article = Article::find($request->id);
    
        $article->is_draft = false;
        $article->save();
    
        return response()->json(true);
    }
}
