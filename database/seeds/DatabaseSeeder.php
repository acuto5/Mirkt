<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Admin user
		factory(\App\User::class)->states('superAdmin')->create();
		factory(\App\User::class)->states('admin')->create();
		factory(\App\User::class)->states('moderator')->create();
	
		// Tags
		factory(\App\Tag::class, 50)->create();
	
		// Categories with sub- categories
		factory(\App\Category::class, 5)->create()->each(function ($category) {
			$category->subCategories()
				->saveMany(factory(\App\SubCategory::class, 3)
							   ->create(['category_id' => $category->id]));
		});
	
		//Published articles with images
		factory(\App\Article::class, 50)
			->create(
				[
					'user_id' => \App\User::first()->id,
				])
			->each(function ($article) {
				$article->update(['is_draft' => $article->id % 2]);
				$article->images()->save(factory(\App\Image::class)->states('default')->create());
				$article->images()->saveMany(factory(\App\Image::class, 3)->create());
				$article->tags()->saveMany(\App\Tag::inRandomOrder()->take(5)->get());
			});
    }
}
