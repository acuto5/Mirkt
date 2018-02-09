<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Http\Requests\Categories\DestroyRequest;
use App\Http\Requests\Categories\EditRequest;
use App\Http\Requests\Categories\GetCategoryArticlesRequest;
use App\Http\Requests\Categories\LevelDownRequest;
use App\Http\Requests\Categories\LevelUpRequest;
use App\Http\Requests\Categories\StoreRequest;

class CategoriesController extends Controller
{
	const ARTICLES_PER_PAGE = 12;
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function get()
	{
		$categories = Category::select('id', 'name', 'level')->orderBy('level', 'desc')->get();
		
		return response()->json($categories);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\GetCategoryArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategoryArticles(GetCategoryArticlesRequest $request)
	{
		$category = Category::where(['name' => $request->category_name])->first();
		
		// Find all sub-categories ids
		$subCategoriesIds = $category->subCategories()->select('id')->get();
		
		// Find articles
		$articles = Article::where('is_draft', 0)
			->whereIn('sub_category_id', $subCategoriesIds)
			->with('headerImage')
			->orderBy('created_at', 'desc')
			->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategoriesAndSubCategories()
	{
		$categories = Category::select('id', 'name')
			->with('subCategories:id,name,category_id')
			->orderBy('level', 'desc')
			->get();
		
		return response()->json($categories);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategoriesWithSubCategoriesAndArticles()
	{
		/**
		 * ** Query not effective! **
		 */
		$data = Category::with('subCategories')->get();
		
		foreach ($data as $category){
			foreach ($category->subCategories as $subCategory){
				$subCategory->latestSixPublishedArticles;
			}
		}
		
		return response()->json($data);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\StoreRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		Category::create($request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditRequest $request)
	{
		$category = Category::find($request->id);
		
		$category->update($request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DestroyRequest $request)
	{
		$category = Category::where('id', $request->id)->withCount('subCategories')->first();
		
		if ($category->sub_categories_count > 0) {
			return response()->json(['message' => 'Cant delete category. This category has sub-categories.'], 500);
		}
		
		$category->delete();
		
		return response()->json(true);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelUp(LevelUpRequest $request)
	{
		$category = Category::find($request->id);
		
		if ($category->level < 200) {
			$category->level++;
			$category->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelDown(LevelDownRequest $request)
	{
		$category = Category::find($request->id);
		
		if ($category->level > 0) {
			$category->level--;
			$category->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
}
