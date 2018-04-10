<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker){
	static $categoryLevel = 1;
	
	echo "Create " . $categoryLevel . " App\Category \n";
	
    return [
        'name' => $faker->unique()->word,
		'level' => $categoryLevel++
    ];
});
