<?php

use Faker\Generator as Faker;

$factory->define(App\SubCategory::class, function (Faker $faker) {
	static $subCategory = 1;
	
    return [
    	'name' => $faker->word,
        'level' => $subCategory++,
    ];
});
