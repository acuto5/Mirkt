<?php
Route::namespace('Articles')->group(function(){
    Route::get('articles/published/search', 'SearchPublishedArticlesController@index')->name('searchInPublishedArticles');
});


