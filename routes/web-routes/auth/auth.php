<?php

// Auth
// Don`t use Auth::routes(), because post routes will be without names

// Later
//Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('passwordEmail');
//Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('passwordEmail');
// Login


Route::prefix('user')->namespace('Auth')->group(function (){
    Route::post('/login', 'LoginController@login')->name('login')->middleware('guest');
    Route::post('/logout', 'LoginController@logout')->name('logout')->middleware('auth');
    Route::post('/register', 'RegisterController@register')->name('register')->middleware('guest');
});
