<?php

Route::namespace('Categories')->group(function(){
    // No middleware
    Route::get('categories/index', 'CategoriesController@index')->name('getCategories');
    
    // Admins and super-admins
    Route::middleware('auth', 'role:admin')->group(function(){
        Route::post('categories/store', 'CategoriesController@store')->name('addCategory');
        Route::patch('categories/update', 'CategoriesController@update')->name('editCategory');
        Route::delete('categories/delete', 'CategoriesController@delete')->name('deleteCategory');
    });
});