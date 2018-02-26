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
use App\Jobs\DeleteSubCategory;
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
		
		$articles = $sub_category->articles()->where('is_draft', 0)->with('headerImage')->orderBy('created_at', 'desc')->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		$subCategory = SubCategory::create($request->all());
		
		// Level up all subCategories
		$this->levelUpAllSubCategories($subCategory->category_id);
		
		DeleteSubCategory::dispatch($subCategory)->delay(now()->addMinutes(15));
		
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
		
		// Check if category change
		if($subCategory->category_id !== $request->get('category_id')){
			$this->levelDownAllSubCategories($subCategory->category_id, $subCategory->level + 1);
			$this->levelUpAllSubCategories($request->get('category_id'));
			$request['level'] = 1;
		}
		
		// Update subCategory
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
		
		$this->levelDownAllSubCategories($subCategory->category_id, $subCategory->level);
		
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
		$countSubCategories = SubCategory::where('category_id', $subCategory->category_id)->count();
		
		if ($subCategory->level < $countSubCategories) {
			$this->levelDownNeighbourSubCategory($subCategory->category_id, $subCategory->level + 1);
			
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
		$subCategory = SubCategory::find($request->id);
		
		if ($subCategory->level > 0) {
			$this->levelUpNeighbourCategory($subCategory->category_id, $subCategory->level - 1);
			
			$subCategory->level--;
			$subCategory->save();
			
			return response()->json(true);
		}
		
		return response()->json(false);
	}
	
	/**
	 * @param integer $NeighbourLevel
	 */
	private function levelUpNeighbourCategory($category_id, $NeighbourLevel)
	{
		$subCategory = SubCategory::where([['level', $NeighbourLevel],['category_id', $category_id]])->first();
		
		if (!empty($subCategory)) {
			$subCategory->level++;
			$subCategory->save();
		}
	}
	
	/**
	 * @param integer $NeighbourLevel
	 */
	private function levelDownNeighbourSubCategory($category_id, $NeighbourLevel)
	{
		$subCategory = SubCategory::where([['level', $NeighbourLevel],['category_id', $category_id]])->first();
		
		if (!empty($subCategory) && $subCategory->level !== 0) {
			$subCategory->level--;
			$subCategory->save();
		}
	}
	
	private function levelUpAllSubCategories($category_id)
	{
		$subCategories = SubCategory::where('category_id', $category_id)->get();
		
		$subCategories->map(function ($subCategory){
			$subCategory->level++;
			$subCategory->save();
		});
	}
	
	private function levelDownAllSubCategories($category_id, $levelDownFrom)
	{
		$subCategories = SubCategory::where([['level', '>', $levelDownFrom],['category_id', $category_id]])->get();
		
		$subCategories->map(function ($subCategory){
			$subCategory->level--;
			$subCategory->save();
		});
	}
	
}
