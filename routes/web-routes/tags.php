<?php

// Get all tags
Route::get('/get-tags', 'TagController@get')->name('getTags')->middleware('auth', 'role:moderator');

// Create tag
Route::post('/add-tag', 'TagController@store')->name('addTag')->middleware('auth', 'role:moderator');

// Edit tag
Route::patch('/edit-tag', 'TagController@edit')->name('editTag')->middleware('auth', 'role:moderator');

// Delete tag
Route::delete('/delete-tag', 'TagController@delete')->name('deleteTag')->middleware('auth', 'role:moderator');

// Take tags
Route::get('/get-all-tags', 'TagController@getAll')->name('getAllTags')->middleware('auth', 'role:moderator');

// Get articles by tag name
Route::get('/get-articles-by-tag-name', 'TagController@getArticlesByTagName')->name('getArticlesByTagName');
    