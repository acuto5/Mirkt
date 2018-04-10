<?php

namespace App\Http\Controllers\Articles;

trait SortArticles
{
    /**
     * Sort articles
     *
     * @param string $columnName
     * @param string $sortBy
     */
    protected function sortByArticlesByDate($columnName, $sortBy = 'newest')
    {
        if ($sortBy === 'oldest') {
            $sortedCollection = $this->articles->sortBy($columnName)->values();
        } else {
            // newest
            $sortedCollection = $this->articles->sortByDesc($columnName)->values();
        }
    
        $this->articles->setCollection($sortedCollection);
    }
}