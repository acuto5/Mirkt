<?php

namespace App\Http\Controllers\SubCategories;

use App\Category;
use App\Http\Requests\SubCategories\SubCategoriesDeleteRequest;
use App\Http\Requests\SubCategories\SubCategoriesIndexRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategories\SubCategoriesStoreRequest;
use App\Http\Requests\SubCategories\SubCategoriesUpdateRequest;
use App\Jobs\DeleteSubCategory;
use App\SubCategory;

class SubCategoriesController extends Controller
{
    const DELETE_AFTER_MINUTES = 15;
    
    /**
     * Get all sub-categories by category id
     *
     * @param \App\Http\Requests\SubCategories\SubCategoriesIndexRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SubCategoriesIndexRequest $request)
    {
        $subCategories = Category::find($request->id)->subCategories()->orderBy('level', 'desc')->get();
        
        return response()->json($subCategories);
    }
    
    /**
     * Create new sub-category
     *
     * @param \App\Http\Requests\SubCategories\SubCategoriesStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SubCategoriesStoreRequest $request)
    {
        $subCategory = new SubCategory();
        $subCategory->fill($request->all())->save();
    
        // Level up all subCategories
        $this->levelUpAllSubCategories($subCategory->category_id);
    
        // queue work
        DeleteSubCategory::dispatch($subCategory)->delay(now()->addMinutes(self::DELETE_AFTER_MINUTES));
    
        return response()->json(true);
    }
    
    /**
     * Update sub-category
     *
     * @param \App\Http\Requests\SubCategories\SubCategoriesUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubCategoriesUpdateRequest $request)
    {
        $subCategory = SubCategory::find($request->id);
    
        // Check if category change
        if ($subCategory->category_id !== $request->get('category_id')) {
            $this->levelDownAllSubCategories($subCategory->category_id, $subCategory->level + 1);
            $this->levelUpAllSubCategories($request->get('category_id'));
            $request['level'] = 1;
        }
    
        // Update subCategory
        $subCategory->update($request->all());
    
        return response()->json(true);
    }
    
    /**
     * Delete sub-category
     *
     * @param \App\Http\Requests\SubCategories\SubCategoriesDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(SubCategoriesDeleteRequest $request)
    {
        $subCategory = SubCategory::where('id', $request->id)->withCount('articles')->first();
    
        if ($subCategory->articles_count > 0) {
            return response()->json(['message' => 'Cant delete sub-category. This sub-category has articles.'], 500);
        }
    
        $subCategory->delete();
    
        $this->levelDownAllSubCategories($subCategory->category_id, $subCategory->level);
    
        return response()->json(true);
    }
    
    
    //------------------------------
    // Private methods
    //------------------------------
    
    /**
     * Level up all sub-categories by category id
     *
     * @param int $category_id
     */
    private function levelUpAllSubCategories($category_id)
    {
        $subCategories = SubCategory::where('category_id', $category_id)->get();
        
        $subCategories->map(function ($subCategory) {
            $subCategory->level++;
            $subCategory->save();
        });
    }
    
    /**
     * Level down all sub-categories by category id and sub-category id
     *
     * @param int $category_id
     * @param int $levelDownFrom
     */
    private function levelDownAllSubCategories($category_id, $levelDownFrom)
    {
        $subCategories = SubCategory::where([['level', '>', $levelDownFrom], ['category_id', $category_id]])->get();
        
        $subCategories->map(function ($subCategory) {
            $subCategory->level--;
            $subCategory->save();
        });
    }
}
