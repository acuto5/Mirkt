<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

// Admin
$factory->state(App\User::class, 'admin', [
	'name' => 'Admin',
	'email' => 'tsmulkys@gmail.com',
	'password' => bcrypt('password'),
	'is_admin' => 1
]);

// Moderator
$factory->state(App\User::class, 'moderator', [
	'name' => 'Moderator',
	'email' => 'samsamot0@gmail.com',
	'password' => bcrypt('password'),
	'is_moderator' => 1
]);
