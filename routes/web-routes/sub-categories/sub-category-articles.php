<?php
Route::namespace('SubCategories')->group(function (){
    Route::get('sub-category/articles', 'SubCategoryArticlesController@index')->name('getArticlesBySubCategoryName');
});