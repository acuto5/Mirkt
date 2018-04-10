<?php
Route::namespace('SubCategories')->group(function (){
    Route::get('sub-category/all', 'SubCategoriesController@index')->name('getSubCategories');
    
    Route::middleware('auth', 'role:moderator')->group(function (){
        Route::post('sub-category/store', 'SubCategoriesController@store')->name('addSubCategory');
        Route::patch('sub-category/update', 'SubCategoriesController@update')->name('editSubCategory');
        Route::delete('sub-category/destroy', 'SubCategoriesController@destroy')->name('deleteSubCategory');
    });
});