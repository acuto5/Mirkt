<?php
// Get categories
Route::get('/get-categories', 'CategoriesController@getAllCategories')->name('getCategories');

// Get Categories with sub-categories and articles
Route::get('/get-categories-with-sub-categories-and-articles', 'CategoriesController@getCategoriesWithSubCategoriesAndArticles')->name('getCategoriesWithSubCategoriesAndArticles');

// Create category
Route::post('/store-category', 'CategoriesController@store')->name('addCategory')->middleware('auth', 'role:admin');

// Edit category
Route::patch('/edit-category', 'CategoriesController@edit')->name('editCategory')->middleware('auth', 'role:admin');

// Delete category
Route::delete('/delete-category', 'CategoriesController@destroy')->name('deleteCategory')->middleware('auth', 'role:admin');

// Level up category
Route::post('/level-up-category', 'CategoriesController@levelUp')->name('levelUpCategory')->middleware('auth', 'role:admin');

// Level dawn category
Route::post('/level-down-category', 'CategoriesController@levelDown')->name('levelDownCategory')->middleware('auth', 'role:admin');

// Get categories and their sub-categories
Route::get('/get-categories-and-sub-categories', 'CategoriesController@getCategoriesAndSubCategories')
	->name('getCategoriesAndSubCategories');

// Get category articles
Route::get('/get-category-articles', 'CategoriesController@getCategoryArticlesByName')->name('getCategoryArticles');
