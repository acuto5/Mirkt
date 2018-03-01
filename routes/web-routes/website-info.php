<?php
Route::get('/get-website-info', 'WebsiteInfoController@getWebsiteInfo')->name('getWebsiteInfo');
Route::patch('/update-website-info', 'WebsiteInfoController@updateWebsiteInfo')->name('updateWebsiteInfo')->middleware('auth', 'role:super');