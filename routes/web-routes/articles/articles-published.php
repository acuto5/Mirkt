<?php
Route::namespace('Articles')->group(function () {
    Route::get('articles/published/all', 'PublishedArticlesController@index')->name('getAllPublishedArticles');
});
