<?php

namespace App\Http\Controllers\Articles;

trait HideArticlesColumns
{
    /**
     * Hide columns in all articles models
     *
     * @param array $columns
     */
    protected function hideColumns($columns)
    {
        $this->articles->transform(function ($article) use ($columns) {
            return $article->makeHidden($columns)->toArray();
        });
    }
}