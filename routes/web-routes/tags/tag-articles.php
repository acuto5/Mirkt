<?php
Route::namespace('Tags')->group(function(){
    Route::get('tags/get-articles-by-tag-name', 'TagArticlesController@index')->name('getArticlesByTagName');
});
