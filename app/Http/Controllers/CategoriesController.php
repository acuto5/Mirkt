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
use App\Jobs\DeleteCategory;

class CategoriesController extends Controller
{
	const ARTICLES_PER_PAGE    = 12;
	const DELETE_AFTER_MINUTES = 15;
	
	private $request;
	
	private $category;
	
	private $categoriesCollection;
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getAllCategories()
	{
		$this->categoriesCollection = Category::select('id', 'name', 'level')->orderBy('level', 'desc')->get();
		
		return response()->json($this->categoriesCollection);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\GetCategoryArticlesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategoryArticlesByName(GetCategoryArticlesRequest $request)
	{
		$this->category = Category::where(['name' => $request->category_name])->first();
		
		// Find all sub-categories ids
		$subCategoriesIds = $this->category->subCategories()->select('id')->get();
		
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
		$with = [
			'subCategories' => function ($query) {
				$query->select('id', 'name', 'level', 'category_id')->orderBy('level', 'desc');
			},
		];
		
		$this->categoriesCollection = Category::select('id', 'name')->with($with)->orderBy('level', 'desc')->get();
		
		return response()->json($this->categoriesCollection);
	}
	
	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategoriesWithSubCategoriesAndArticles()
	{
		/**
		 * ** Query not effective! **
		 */
		$this->category = Category::with('subCategories')->get();
		
		foreach ($this->category as $category) {
			foreach ($category->subCategories as $subCategory){
				$subCategory->latestEightPublishedArticles;
			}
		}
		
		return response()->json($this->category);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\StoreRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		$this->request  = $request;
		$this->category = new Category();
		$this->category->fill($this->request->all())->save();
		
		// Level app all categories by 1
		$this->levelUpAllCategories();
		
		DeleteCategory::dispatch($this->category)->delay(now()->addMinutes(self::DELETE_AFTER_MINUTES));
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\EditRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditRequest $request)
	{
		$this->request  = $request;
		$this->category = Category::find($request->id);
		
		$this->category->update($this->request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\DestroyRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(DestroyRequest $request)
	{
		$this->category = Category::where('id', $request->id)->withCount('subCategories')->first();
		
		if ($this->category->sub_categories_count > 0) {
			return response()->json(['message' => 'Cant delete category. This category has sub-categories.'], 500);
		}
		
		$this->category->delete();
		
		$this->levelDownAllCategories($this->category->level);
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\LevelUpRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelUp(LevelUpRequest $request)
	{
		$this->request   = $request;
		$this->category  = Category::find($request->id);
		$countCategories = Category::count();
		
		if ($this->category->level < $countCategories) {
			
			$this->levelDownNeighbourCategory($this->category->level + 1);
			
			$this->category->level++;
			$this->category->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
	
	/**
	 * @param \App\Http\Requests\Categories\LevelDownRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelDown(LevelDownRequest $request)
	{
		$this->category = Category::find($request->id);
		
		if ($this->category->level > 0) {
			$this->levelUpNeighbourCategory($this->category->level - 1);
			
			$this->category->level--;
			$this->category->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
	
	/**
	 * @param integer $level
	 */
	private function levelUpNeighbourCategory($level)
	{
		$category = Category::where('level', $level)->first();
		
		if (!empty($category)) {
			$category->level++;
			$category->save();
		}
	}
	
	/**
	 * @param integer $level
	 */
	private function levelDownNeighbourCategory($level)
	{
		$category = Category::where('level', $level)->first();
		
		if (!empty($category) && $category->level !== 0) {
			$category->level--;
			$category->save();
		}
	}
	
	private function levelUpAllCategories()
	{
		$categories = Category::all();
		
		$categories->map(function ($category) {
			$category->level++;
			$category->save();
			
			return $category;
		});
	}
	
	/**
	 * @param integer $levelDownFrom
	 */
	private function levelDownAllCategories($levelDownFrom)
	{
		$categories = Category::where('level', '>', $levelDownFrom)->get();
		
		$categories->map(function ($category) {
			$category->level--;
			$category->save();
		});
	}
	
}
