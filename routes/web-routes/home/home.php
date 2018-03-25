<?php
Route::namespace('Home')->group(function () {
    Route::get('home-articles', 'HomeArticlesController@index')->name('getHomeArticles');
});