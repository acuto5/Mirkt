<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\SubCategories\DeleteRequest;
use App\Http\Requests\SubCategories\EditRequest;
use App\Http\Requests\SubCategories\GetArticlesBySubCategoryNameRequest;
use App\Http\Requests\SubCategories\GetRequest;
use App\Http\Requests\SubCategories\LevelDownRequest;
use App\Http\Requests\SubCategories\LevelUpRequest;
use App\Http\Requests\SubCategories\StoreRequest;
use App\SubCategory;

class SubCategoryController extends Controller
{
	const ARTICLES_PER_PAGE = 12;
	
	/**
	 * @param \App\Http\Requests\SubCategories\GetRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getSubCategories(GetRequest $request)
	{
		$subCategories = Category::find($request->id)->subCategories;
		
		return response()->json($subCategories);
	}
	
	public function getArticlesBySubCategoryName(GetArticlesBySubCategoryNameRequest $request)
	{
		$sub_category = SubCategory::where('name', $request->sub_category_name)->first();
		
		$articles = $sub_category->articles()->with('headerImage')->orderBy('created_at', 'desc')->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		SubCategory::create($request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditRequest $request)
	{
		$subCategory = SubCategory::find($request->id);
		
		$subCategory->update($request->all());
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\DeleteRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(DeleteRequest $request)
	{
		/**
		 * Only Admin/Moderator
		 */
		$subCategory = SubCategory::where('id', $request->id)->withCount('articles')->first();
		
		if ($subCategory->articles_count > 0) {
			return response()->json(['message' => 'This sub-category has relationships with articles.'], 500);
		}
		
		// delete
		$subCategory->delete();
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\LevelUpRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelUp(LevelUpRequest $request)
	{
		/**
		 * Only Admin/Moderator
		 */
		$subCategory = SubCategory::find($request->id);
		
		if ($subCategory->level < 200) {
			$subCategory->level++;
			$subCategory->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\LevelDownRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelDown(LevelDownRequest $request)
	{
		/**
		 * Only Admin/Moderator
		 */
		$subCategory = SubCategory::find($request->id);
		
		if ($subCategory->level > 0) {
			$subCategory->level--;
			$subCategory->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
	
}
