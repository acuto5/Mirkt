<?php

namespace App\Http\Controllers\Articles;

use App\Http\Requests\Articles\SearchDraftArticlesIndexRequest;
use App\Http\Controllers\Controller;

class SearchDraftArticlesController extends Controller
{
    use SearchArticles, SortArticles, HideArticlesColumns;
    
    const ARTICLES_PER_PAGE = 12;
    
    protected $request;
    protected $articles;
    
    /**
     * Search draft articles
     *
     * @param \App\Http\Requests\Articles\SearchDraftArticlesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchDraftArticlesIndexRequest $request)
    {
        $this->request = $request;
    
        // Find articles
        $this->articles = $this->searchArticles(true);
        $this->articles->load('headerImage');
    
        // If user choose orderBy, by oldest articles
        $this->sortByArticlesByDate('created_at', $this->request->get('order_by'));
    
        // Remove columns
        $this->hideColumns(['content', 'sub_category_id', 'is_draft']);
    
        return response()->json($this->articles->toArray());
    }
}
