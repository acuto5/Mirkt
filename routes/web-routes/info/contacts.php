<?php
Route::prefix('info/contacts')->namespace('Info')->group(function(){
    Route::get('', 'ContactsController@show')->name('getContacts');
    
    
    Route::middleware('auth', 'role:super')->group(function (){
        Route::patch('update', 'ContactsController@update')->name('updateContacts');
    });
});
