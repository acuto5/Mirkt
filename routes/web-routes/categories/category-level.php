<?php
Route::namespace('Categories')->middleware('auth', 'role:admin')->group(function (){
    Route::patch('category/level-up', 'CategoryLevelUpController@update')->name('levelUpCategory');
    Route::patch('category/level-down', 'CategoryLevelDownController@update')->name('levelDownCategory');
});


