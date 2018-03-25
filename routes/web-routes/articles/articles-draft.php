<?php
Route::namespace('Articles')->middleware('auth', 'role:moderator')->group(function(){
    Route::get('articles/draft/all', 'DraftArticlesController@index')->name('getAllDraftArticles');
});

