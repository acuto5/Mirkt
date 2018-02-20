<?php

// Auth
// Don`t use Auth::routes(), because post routes will be without names

// Later
//Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('passwordEmail');
//Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('passwordEmail');
// Login
Route::post('/login', 'Auth\LoginController@login')->name('login')->middleware('guest');

// Logout
Route::post('/logout', 'Auth\LoginController@logout')->name('logout')->middleware('auth');

Route::post('/register', 'Auth\RegisterController@register')->name('register')->middleware('guest');
