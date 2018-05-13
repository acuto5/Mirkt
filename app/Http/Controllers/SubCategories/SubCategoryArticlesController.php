<?php

namespace App\Http\Controllers\SubCategories;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategories\SubCategoryArticlesIndexRequest;
use App\SubCategory;

class SubCategoryArticlesController extends Controller
{
    /**
     * Get all sub-category articles
     *
     * @param \App\Http\Requests\SubCategories\SubCategoryArticlesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SubCategoryArticlesIndexRequest $request)
    {
        $subCategory = SubCategory::where('name', $request->sub_category_name)->first();
    
        $articles = $subCategory->articles()
            ->where('is_draft', 0)
            ->with('headerImage')
            ->latest()
            ->paginate(config('app.articles_per_page', 12));
    
        return response()->json($articles);
    }
}
