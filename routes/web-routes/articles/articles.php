<?php
Route::namespace('Articles')->group(function(){
    Route::get('article/show', 'ArticleController@show')->name('getArticle');
    
    Route::middleware('auth', 'role:moderator')->group(function(){
        Route::post('article/store', 'ArticleController@store')->name('postArticle');
        Route::patch('article/update', 'ArticleController@update')->name('editArticle');
        Route::delete('article/delete', 'ArticleController@delete')->name('deleteArticle');
    });
});