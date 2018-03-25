<?php

namespace App\Http\Controllers\SubCategories;

use App\Http\Requests\SubCategories\SubCategoryLevelUpUpdateRequest;
use App\SubCategory;
use App\Http\Controllers\Controller;

class SubCategoryLevelUpController extends Controller
{
    /**
     * Level up sub-category level
     *
     * @param \App\Http\Requests\SubCategories\SubCategoryLevelUpUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubCategoryLevelUpUpdateRequest $request)
    {
        $subCategory  = SubCategory::find($request->id);
        $countSubCategories = SubCategory::where('category_id', $subCategory->category_id)->count();
    
        if ($subCategory->level < $countSubCategories) {
            $this->levelDownSubCategoryNeighbour($subCategory->category_id, $subCategory->level + 1);
        
            $subCategory->level++;
            $subCategory->save();
        
            return response()->json(true);
        }
    
        return response()->json(false, 500);
    }
    
    /**
     * Level down sub-category neighbor
     *
     * @param integer $category_id
     * @param integer $NeighbourLevel
     */
    private function levelDownSubCategoryNeighbour($category_id, $NeighbourLevel)
    {
        $subCategory = SubCategory::where([['level', $NeighbourLevel], ['category_id', $category_id]])->first();
        
        if (!empty($subCategory) && $subCategory->level !== 0) {
            $subCategory->level--;
            $subCategory->save();
        }
    }
}
