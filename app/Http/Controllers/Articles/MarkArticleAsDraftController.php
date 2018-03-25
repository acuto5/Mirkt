<?php

namespace App\Http\Controllers\Articles;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articles\MarkArticleAsDraftUpdateRequest;

class MarkArticleAsDraftController extends Controller
{
    /**
     * Mark article ar draft
     *
     * @param \App\Http\Requests\Articles\MarkArticleAsDraftUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MarkArticleAsDraftUpdateRequest $request)
    {
        $article = Article::find($request->id);
    
        $article->is_draft = true;
        $article->save();
    
        return response()->json(true);
    }
}
