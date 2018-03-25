<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Requests\Categories\CategoryLevelDownUpdateRequest;
use App\Http\Controllers\Controller;

class CategoryLevelDownController extends Controller
{
    /**
     * Level down category
     *
     * @param \App\Http\Requests\Categories\CategoryLevelDownUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryLevelDownUpdateRequest $request)
    {
        $category = Category::find($request->id);
        
        if ($category->level > 0) {
            $this->levelUpCategoryNeighbour($category->level - 1);
            
            $category->level--;
            $category->save();
            
            return response()->json(true);
        }
        
        return response()->json(false);
    }
    
    /**
     * Level up category neighbour
     *
     * @param int $level
     */
    private function levelUpCategoryNeighbour($level)
    {
        $category = Category::where('level', $level)->first();
        
        if (!empty($category)) {
            $category->level++;
            $category->save();
        }
    }
}
