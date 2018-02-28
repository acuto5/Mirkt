<?php
// Get all published articles
Route::get('/get-all-published-articles', 'ArticleController@getAllPublishedArticles')->name('getAllPublishedArticles');

// Get single article
Route::get('/get-article', 'ArticleController@getArticle')->name('getArticle');

// Create new article
Route::post('/post-article', 'ArticleController@store')->name('postArticle')->middleware('auth', 'role:moderator');

// Edit article
Route::patch('/edit-article', 'ArticleController@edit')->name('editArticle')->middleware('auth', 'role:moderator');

// Delete article
Route::delete('/delete-article', 'ArticleController@delete')->name('deleteArticle')->middleware('auth', 'role:moderator');

// Get draft articles
Route::get('/get-all-draft-articles', 'ArticleController@getAllDraftArticles')
	->name('getAllDraftArticles')
	->middleware('auth', 'role:moderator');

// Search published articles
Route::get('/search-published-articles', 'ArticleController@searchInPublishedArticles')
	->name('searchInPublishedArticles');

// Search draft articles
Route::get('/search-draft-articles', 'ArticleController@searchInDraftArticles')
	->name('searchInDraftArticles')
	->middleware('auth', 'role:moderator');

// Mark article as published
Route::patch('mark-article-as-published', 'ArticleController@markArticleAsPublished')
	->name('markArticleAsPublished')
	->middleware('auth', 'role:moderator');

// Mark article as draft
Route::patch('/mark-article-as-draft', 'ArticleController@markArticleAsDraft')
	->name('markArticleAsDraft')
	->middleware('auth', 'role:moderator');