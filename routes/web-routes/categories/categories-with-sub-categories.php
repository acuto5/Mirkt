<?php
Route::prefix('get-categories-with-sub-categories')->namespace('Categories')->group(function () {
    Route::get('', 'CategoriesSubCategoriesController@index')->name('getCategoriesAndSubCategories');
});

