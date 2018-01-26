<?php

// Update user profile
Route::patch('/update-user-profile', 'UserController@updateProfile')->name('updateUserProfile')->middleware('auth');
    