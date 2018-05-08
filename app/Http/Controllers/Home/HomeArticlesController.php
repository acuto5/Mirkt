<?php

namespace App\Http\Controllers\Home;

use App\Category;
use App\Http\Controllers\Controller;

class HomeArticlesController extends Controller
{
    /**
     * Get home articles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /**
         * ** Query not effective! **
         */
        $categories = Category::with([
            'subCategories' => function ($query) {
                $query->orderBy('level', 'desc');
            },
        ])->orderBy('level', 'desc')
            ->get();
        
        foreach ($categories as $category) {
            foreach ($category->subCategories as $subCategory) {
                $subCategory['articles'] = $subCategory->latestEightPublishedArticles()->get();
            }
        }
        
        return response()->json($categories);
    }
}
