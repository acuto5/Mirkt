<?php

namespace App\Http\Controllers\Categories;

use App\Article;
use App\Category;
use App\Http\Requests\Categories\CategoryArticlesIndexRequest;
use App\Http\Controllers\Controller;

class CategoryArticlesController extends Controller
{
    /**
     * Get category articles by category name
     *
     * @param \App\Http\Requests\Categories\CategoryArticlesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CategoryArticlesIndexRequest $request)
    {
        $category = Category::where(['name' => $request->category_name])->first();
    
        // Find all sub-categories ids
        $subCategoriesIds = $category->subCategories()->select('id')->get();
    
        // Find articles
        $articles = Article::where('is_draft', 0)
            ->whereIn('sub_category_id', $subCategoriesIds)
            ->with('headerImage')
            ->orderBy('created_at', 'desc')
            ->paginate(env('ARTICLES_PER_PAGE', 12));
    
        return response()->json($articles);
    }
}
