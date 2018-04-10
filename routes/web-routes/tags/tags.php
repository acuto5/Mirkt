<?php
/** Tags */
Route::namespace('Tags')->middleware('auth', 'role:moderator')->group(function () {
    Route::get('tags/get-all', 'TagsController@getAll')->name('getAllTags');
    
    Route::get('tags/index', 'TagsController@index')->name('getTags'); // search to
    Route::post('tags/store', 'TagsController@store')->name('storeTag');
    Route::patch('tags/update', 'TagsController@update')->name('updateTag');
    Route::delete('tags/destroy', 'TagsController@destroy')->name('destroyTag');
});