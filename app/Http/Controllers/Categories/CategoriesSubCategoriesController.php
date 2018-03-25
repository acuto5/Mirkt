<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\Controller;

class CategoriesSubCategoriesController extends Controller
{
    /**
     * Get all categories with sub-categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $with = [
            'subCategories' => function ($query) {
                $query->select('id', 'name', 'level', 'category_id')->orderBy('level', 'desc');
            },
        ];
    
        $categories = Category::select('id', 'name')->with($with)->orderBy('level', 'desc')->get();
    
        return response()->json($categories);
    }
}
