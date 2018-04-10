<?php

use Faker\Generator as Faker;

$factory->define(App\SubCategory::class, function (Faker $faker) {
	static $subCategory = 1;
	
	echo "Create " . $subCategory . " App\SubCategory \n";
	
    return [
    	'name' => $faker->word,
        'level' => $subCategory++,
    ];
});
