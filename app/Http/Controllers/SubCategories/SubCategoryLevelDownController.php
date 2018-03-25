<?php

namespace App\Http\Controllers\SubCategories;

use App\Http\Requests\SubCategories\SubCategoryLevelDownUpdateRequest;
use App\SubCategory;
use App\Http\Controllers\Controller;

class SubCategoryLevelDownController extends Controller
{
    /**
     * Level up sub-category
     *
     * @param \App\Http\Requests\SubCategories\SubCategoryLevelDownUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SubCategoryLevelDownUpdateRequest $request)
    {
        $subCategory = SubCategory::find($request->id);
    
        if ($subCategory->level > 0) {
            $this->levelUpSubCategoryNeighbour($subCategory->category_id, $subCategory->level - 1);
        
            $subCategory->level--;
            $subCategory->save();
        
            return response()->json(true);
        }
    
        return response()->json(false, 500);
    }
    
    /**
     * Level up sub-category neighbour
     *
     * @param int $category_id
     * @param int $NeighbourLevel
     */
    private function levelUpSubCategoryNeighbour($category_id, $NeighbourLevel)
    {
        $subCategory = SubCategory::where([['level', $NeighbourLevel], ['category_id', $category_id]])->first();
        
        if (!empty($subCategory)) {
            $subCategory->level++;
            $subCategory->save();
        }
    }
}
