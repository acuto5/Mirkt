<?php

namespace App\Http\Controllers\Articles;

use App\Http\Requests\Articles\SearchPublishedArticlesIndexRequest;
use App\Http\Controllers\Controller;

class SearchPublishedArticlesController extends Controller
{
    use SearchArticles, SortArticles, HideArticlesColumns;
    
    protected $request;
    protected $articles;
    
    /**
     * Search published articles
     *
     * @param \App\Http\Requests\Articles\SearchPublishedArticlesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchPublishedArticlesIndexRequest $request)
    {
        $this->request = $request;
    
        // Find articles
        $this->articles = $this->searchArticles(false);
        $this->articles->load('headerImage');
    
        // If user choose orderBy, by oldest articles
        $this->sortByArticlesByDate('created_at', $this->request->get('order_by'));
    
        // Remove columns
        $this->hideColumns(['content', 'sub_category_id', 'is_draft']);
    
        return response()->json($this->articles->toArray());
    }
}
