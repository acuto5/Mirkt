<?php

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createArticles             = 150;
        $createImagesForEachArticle = 3; // plus default image
        
        factory(\App\Article::class, $createArticles)
            ->create()
            ->each(function ($article) use ($createImagesForEachArticle) {
                // Mark half articles as draft and other half as published
                $article->update(['is_draft' => $article->id % 2]);
                
                // Create default image
                $article->images()->save(factory(\App\Image::class)->states('default')->create());
                
                // Add more images
                $article->images()->saveMany(factory(\App\Image::class, $createImagesForEachArticle)->create());
                
                // Make relationships with random tags
                $article->tags()->saveMany(\App\Tag::inRandomOrder()->take(5)->get());
            });
    }
}
