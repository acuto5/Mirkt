<?php
Route::namespace('Articles')->middleware('auth', 'role:moderator')->group(function(){
    Route::patch('article/published/mark', 'MarkArticleAsPublishedController@update')->name('markArticleAsPublished');
});



