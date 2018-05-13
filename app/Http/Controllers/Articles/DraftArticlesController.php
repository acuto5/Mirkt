<?php

namespace App\Http\Controllers\Articles;

use App\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\Articles\DraftArticlesIndexRequest;

class DraftArticlesController extends Controller
{
    
    /**
     * Get all draft articles
     *
     * @param \App\Http\Requests\Articles\DraftArticlesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DraftArticlesIndexRequest $request)
    {
        $orderBy = 'created_at';
        $with    = 'headerImage';
        $where   = [['is_draft', true]];
        $select  = ['id', 'title', 'sub_category_id', 'created_at'];
        $isDesc  = (isset($request->order_by) && $request->order_by === 'oldest') ? 'asc' : 'desc';
        
        $articlesCollection = Article::select($select)
            ->where($where)
            ->with($with)
            ->orderBy($orderBy, $isDesc)
            ->paginate(config('app.articles_per_page', 12));
        
        return response()->json($articlesCollection);
    }
}
