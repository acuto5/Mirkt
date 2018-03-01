<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker){
	static $countTags = 1;
	echo "Create " . $countTags++ . " App\Tag. \n";
	
    return [
        'name' => $faker->unique()->word
    ];
});
