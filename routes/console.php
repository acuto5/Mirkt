<?php

use App\User;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
	$this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

// Make admin
Artisan::command('make:Admin {id}', function ($id) {
	$user = User::findOrFail($id);
	$user->is_admin = true;
	$user->save();
	
})->describe('Promote user to admin.');
