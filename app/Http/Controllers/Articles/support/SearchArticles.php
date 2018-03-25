<?php

namespace App\Http\Controllers\Articles;

use App\Article;

trait SearchArticles
{
    /**
     * @param $searchInDraft
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function searchArticles($searchInDraft)
    {
        if ($this->request->get('sub_category_id', false)) {
            return $this->searchArticlesWithSubCategory($searchInDraft);
        }
        
        return $this->searchArticlesWithoutSubCategory($searchInDraft);
    }
    
    /**
     * Search articles without sub-category
     *
     * @param boolean $searchInDraft
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function searchArticlesWithoutSubCategory($searchInDraft)
    {
        return Article::search($this->request->get('title'))
            ->where('is_draft', (int)$searchInDraft)
            ->paginate(self::ARTICLES_PER_PAGE);
    }
    
    /**
     * Search articles with sub-category id
     *
     * @param boolean $searchInDraft
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function searchArticlesWithSubCategory($searchInDraft)
    {
        return Article::search($this->request->get('title'))
            ->where('is_draft', (int)$searchInDraft)
            ->where('sub_category_id', $this->request->get('sub_category_id'))
            ->paginate(self::ARTICLES_PER_PAGE);
    }
}