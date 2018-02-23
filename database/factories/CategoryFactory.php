<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker){
	static $categoryLevel = 1;
    return [
        'name' => $faker->unique()->word,
		'level' => $categoryLevel++
    ];
});
