<?php

// Get sub-categories
Route::get('/get-sub-categories', 'SubCategoryController@getSubCategories')->name('getSubCategories');

// Create sub-category
Route::post('/store-sub-category', 'SubCategoryController@store')->name('addSubCategory')->middleware('auth', 'role:moderator');

// Edit sub-category
Route::patch('/edit-sub-category', 'SubCategoryController@edit')->name('editSubCategory')->middleware('auth', 'role:moderator');

// Delete sub-category
Route::delete('/delete-sub-category', 'SubCategoryController@delete')->name('deleteSubCategory')->middleware('auth', 'role:moderator');

// Level up sub-category
Route::post('/level-up-sub-category', 'SubCategoryController@levelUp')->name('levelUpSubCategory')->middleware('auth', 'role:moderator');

// Level Down sub-category
Route::post('/level-down-sub-category', 'SubCategoryController@levelDown')->name('levelDownSubCategory')->middleware('auth', 'role:moderator');

// Get Articles by sub-category name
Route::get('/get-articles-by-sub-category-name', 'SubCategoryController@getArticlesBySubCategoryName')->name('getArticlesBySubCategoryName');



    