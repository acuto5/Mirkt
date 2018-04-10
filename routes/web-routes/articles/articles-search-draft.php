<?php
Route::namespace('Articles')->middleware('auth', 'role:moderator')->group(function(){
    Route::get('articles/draft/search', 'SearchDraftArticlesController@index')->name('searchInDraftArticles');
});


