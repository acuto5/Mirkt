<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
	static $countArticles = 1;
	echo "Create " . $countArticles++ . " App\Article \n";
	
	return [
		'title'           => $faker->unique()->sentence,
		'content'         => $faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '
							 .$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '
							 .$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '
							 .$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '.$faker->text.' '
							 .$faker->text,
		'is_draft'        => 0,
		'sub_category_id' => \App\SubCategory::inRandomOrder()->first()->id,
	];
});
