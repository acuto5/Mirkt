<?php
Route::namespace('User')->middleware('auth')->group(function(){
    Route::patch('user/update', 'UserController@update')->name('updateUserProfile');
});
