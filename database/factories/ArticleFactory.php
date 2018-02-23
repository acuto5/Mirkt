<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
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
