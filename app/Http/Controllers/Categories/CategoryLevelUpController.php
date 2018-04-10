<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryLevelUpUpdateRequest;

class CategoryLevelUpController extends Controller
{
    /**
     * Level up category
     *
     * @param \App\Http\Requests\Categories\CategoryLevelUpUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryLevelUpUpdateRequest $request)
    {
        $category  = Category::find($request->id);
        $countCategories = Category::count();
    
        // Level down neighbour if exists
        if ($category->level < $countCategories) {
        
            $this->levelDownCategoryNeighbour($category->level + 1);
    
            $category->level++;
            $category->save();
        
            return response()->json(true);
        }
    
        return response()->json(false);
    }
    
    /**
     * Level down category neighbour
     *
     * @param int $level
     */
    private function levelDownCategoryNeighbour($level)
    {
        $category = Category::where('level', $level)->first();
        
        if (!empty($category) && $category->level !== 0) {
            $category->level--;
            $category->save();
        }
    }
}
