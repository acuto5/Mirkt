<?php
Route::namespace('Articles')->middleware('auth', 'role:moderator')->group(function () {
    Route::patch('articles/draft/mark', 'MarkArticleAsDraftController@update')->name('markArticleAsDraft');
});

