<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
	$diskName = 'article-images';
	static $countImages = 1;
	
	echo "Create " . $countImages++ . " App\Image \n";
	
	return [
		'url'        => \Illuminate\Support\Facades\Storage::disk($diskName)
			->url($faker->image('public/storage/article/images', 640, 480, null, false)),
		'article_id' => null,
	];
});

$factory->state(\App\Image::class, 'default', ['is_default' => 1]);
