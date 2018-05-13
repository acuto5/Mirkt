<?php

namespace App\Http\Controllers\Categories;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CategoryDeleteRequest;
use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Jobs\DeleteCategory;

class CategoriesController extends Controller
{
    /**
     * Get all categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::select('id', 'name', 'level')->orderBy('level', 'desc')->get();
        
        return response()->json($categories);
    }
    
    /**
     * Create category
     *
     * @param \App\Http\Requests\Categories\CategoryStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();
        $category->fill($request->all())->save();
        
        // Level app all categories by 1
        $this->levelUpAllCategories();

        if(config('app.delete_new_content')){
            DeleteCategory::dispatch($category)->delay(now()->addMinutes(config('app.delete_content_after_minutes', 5)));
        }

        return response()->json(true);
    }
    
    /**
     * Update category
     *
     * @param \App\Http\Requests\Categories\CategoryUpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryUpdateRequest $request)
    {
        Category::find($request->id)->update($request->all());
        
        return response()->json(true);
    }
    
    /**
     * Delete Category
     *
     * @param \App\Http\Requests\Categories\CategoryDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(CategoryDeleteRequest $request)
    {
        $category = Category::where('id', $request->id)->withCount('subCategories')->first();
    
        if ($category->sub_categories_count > 0) {
            return response()->json(['message' => 'Cant delete category. This category has sub-categories.'], 500);
        }
    
        $category->delete();
    
        $this->levelDownAllCategories($category->level);
    
        return response()->json(true);
    }
    
    //------------------------------
    // Private methods
    //------------------------------
    
    /**
     * Level up all categories
     */
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
     * Level down all categories
     *
     * @param $levelDownFrom
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
