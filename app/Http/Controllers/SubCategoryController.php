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
	const DELETE_AFTER_MINUTES = 15;
	
	private $request;
	
	private $subCategory;
	
	private $subCategoriesCollection;
	
	/**
	 * @param \App\Http\Requests\SubCategories\GetRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getSubCategories(GetRequest $request)
	{
		$this->subCategoriesCollection = Category::find($request->id)->subCategories()->orderBy('level', 'desc')->get();
		
		return response()->json($this->subCategoriesCollection);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\GetArticlesBySubCategoryNameRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getArticlesBySubCategoryName(GetArticlesBySubCategoryNameRequest $request)
	{
		$this->subCategory = SubCategory::where('name', $request->sub_category_name)->first();
		
		$articles = $this->subCategory->articles()
			->where('is_draft', 0)
			->with('headerImage')
			->latest()
			->paginate(self::ARTICLES_PER_PAGE);
		
		return response()->json($articles);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\StoreRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(StoreRequest $request)
	{
		$this->request = $request;
		$this->subCategory = new SubCategory();
		$this->subCategory->fill($this->request->all())->save();
		
		// Level up all subCategories
		$this->levelUpAllSubCategories($this->subCategory->category_id);
		
		// queue work
		DeleteSubCategory::dispatch($this->subCategory)->delay(now()->addMinutes(self::DELETE_AFTER_MINUTES));
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\EditRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function edit(EditRequest $request)
	{
		$this->request = $request;
		$this->subCategory = SubCategory::find($request->id);
		
		// Check if category change
		if($this->subCategory->category_id !== $this->request->get('category_id')){
			$this->levelDownAllSubCategories($this->subCategory->category_id, $this->subCategory->level + 1);
			$this->levelUpAllSubCategories($this->request->get('category_id'));
			$this->request['level'] = 1;
		}
		
		// Update subCategory
		$this->subCategory->update($this->request->all());
		
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\DeleteRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(DeleteRequest $request)
	{
		$this->subCategory = SubCategory::where('id', $request->id)->withCount('articles')->first();
		
		if ($this->subCategory->articles_count > 0) {
			return response()->json(['message' => 'This sub-category has relationships with articles.'], 500);
		}
		
		// delete
		$this->subCategory->delete();
		
		$this->levelDownAllSubCategories($this->subCategory->category_id, $this->subCategory->level);
		
		return response()->json(true);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\LevelUpRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelUp(LevelUpRequest $request)
	{
		$this->subCategory = SubCategory::find($request->id);
		$countSubCategories = SubCategory::where('category_id', $this->subCategory->category_id)->count();
		
		if ($this->subCategory->level < $countSubCategories) {
			$this->levelDownNeighbourSubCategory($this->subCategory->category_id, $this->subCategory->level + 1);
			
			$this->subCategory->level++;
			$this->subCategory->save();
			
			return response()->json(true);
		}
		
		return response()->json(false, 500);
	}
	
	/**
	 * @param \App\Http\Requests\SubCategories\LevelDownRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function levelDown(LevelDownRequest $request)
	{
		$this->subCategory = SubCategory::find($request->id);
		
		if ($this->subCategory->level > 0) {
			$this->levelUpNeighbourCategory($this->subCategory->category_id, $this->subCategory->level - 1);
			
			$this->subCategory->level--;
			$this->subCategory->save();
			
			return response()->json(true);
		}
		
		return response()->json(false, 500);
	}
	
	/**
	 * @param integer $category_id
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
	 * @param integer $category_id
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
	
	/**
	 * @param integer $category_id
	 */
	private function levelUpAllSubCategories($category_id)
	{
		$subCategories = SubCategory::where('category_id', $category_id)->get();
		
		$subCategories->map(function ($subCategory){
			$subCategory->level++;
			$subCategory->save();
		});
	}
	
	/**
	 * @param integer $category_id
	 * @param integer $levelDownFrom
	 */
	private function levelDownAllSubCategories($category_id, $levelDownFrom)
	{
		$subCategories = SubCategory::where([['level', '>', $levelDownFrom],['category_id', $category_id]])->get();
		
		$subCategories->map(function ($subCategory){
			$subCategory->level--;
			$subCategory->save();
		});
	}
	
}
