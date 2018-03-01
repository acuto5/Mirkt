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
    	$createTags = 50;
    	$createCategories = 5;
		$createSubCategoriesForEachCategory = 3;
		$createArticles = 150;
		$createImagesForEachArticle = 3; // plus default image
  
		// Admin user
		factory(\App\User::class)->states('superAdmin')->create();
		factory(\App\User::class)->states('admin')->create();
		factory(\App\User::class)->states('moderator')->create();
	
		// Tags
		factory(\App\Tag::class, $createTags)->create();
	
		// Categories with sub-categories
		factory(\App\Category::class, $createCategories)->create()->each(function ($category) use($createSubCategoriesForEachCategory){
			// Create 3 subCategories
			// Use foreach to override level
			for($i=0; $i<$createSubCategoriesForEachCategory; $i++) {
				$category->subCategories()
					->save(
						factory(\App\SubCategory::class)->create(['category_id' => $category->id, 'level' => $i])
					);
			}
		});
	
		//Published articles with images
		factory(\App\Article::class, $createArticles)
			->create(
				[
					'user_id' => \App\User::first()->id,
				])
			->each(function ($article) use($createImagesForEachArticle){
				$article->update(['is_draft' => $article->id % 2]);
				$article->images()->save(factory(\App\Image::class)->states('default')->create());
				$article->images()->saveMany(factory(\App\Image::class, $createImagesForEachArticle)->create());
				$article->tags()->saveMany(\App\Tag::inRandomOrder()->take(5)->get());
			});
    }
}
