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

    echo "Create App\User \n";

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'is_super_admin' => 0,
        'is_moderator' => 0,
        'is_admin' => 0,
    ];
});

// Super admin
$factory->state(App\User::class, 'superAdmin', [
    'name' => 'Super',
    'email' => 'super@mirkt.lt',
    'password' => bcrypt(config('app.super_admin_pass', 'password')),
    'is_super_admin' => 1,
    'is_moderator' => 1,
    'is_admin' => 1,
]);

// Admin
$factory->state(App\User::class, 'admin', [
    'name' => 'Admin',
    'email' => 'admin@mirkt.lt',
    'password' => bcrypt('password'),
    'is_super_admin' => 0,
    'is_moderator' => 1,
    'is_admin' => 1,

]);

// Moderator
$factory->state(App\User::class, 'moderator', [
    'name' => 'Moderator',
    'email' => 'moderator@mirkt.lt',
    'password' => bcrypt('password'),
    'is_super_admin' => 0,
    'is_moderator' => 1,
    'is_admin' => 0,
]);
