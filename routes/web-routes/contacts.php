<?php
Route::get('/get-contacts', 'ContactsController@getContacts')->name('getContacts');
Route::patch('/update-contacts', 'ContactsController@updateContacts')->name('updateContacts')->middleware('auth', 'role:super');