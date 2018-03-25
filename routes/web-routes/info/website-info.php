<?php
Route::prefix('info/website-info')->namespace('Info')->group(function(){
    Route::get('content', 'WebsiteInfoController@show')->name('getWebsiteInfo');
    
    Route::middleware('auth', 'role:super')->group(function (){
        Route::patch('update', 'WebsiteInfoController@update')->name('updateWebsiteInfo');
    });
});
