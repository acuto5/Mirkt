<?php
Route::namespace('SubCategories')->middleware('auth', 'role:moderator')->group(function(){
    Route::patch('sub-category/level-up', 'SubCategoryLevelUpController@update')->name('levelUpSubCategory');
    Route::patch('sub-category/level-down', 'SubCategoryLevelDownController@update')->name('levelDownSubCategory');
});

