<?php
Route::namespace('Categories')->group(function (){
    Route::get('categories/articles', 'CategoryArticlesController@index')->name('getCategoryArticles');
});
