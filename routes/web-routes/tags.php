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
Route::get('/take-tags', 'TagController@takeTags')->name('takeTags')->middleware('auth', 'role:moderator');
Route::get('/get-all-tags', 'TagController@getAll')->name('getAllTags')->middleware('auth', 'role:moderator');

    