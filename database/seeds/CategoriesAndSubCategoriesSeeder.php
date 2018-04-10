<?php

use Illuminate\Database\Seeder;

class CategoriesAndSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $createCategories                   = 5;
        $createSubCategoriesForEachCategory = 3;
        
        factory(\App\Category::class, $createCategories)
            ->create()
            ->each(function ($category) use ($createSubCategoriesForEachCategory) {
                // Create 3 subCategories
                // Use foreach to override level
                for ($i = 0; $i < $createSubCategoriesForEachCategory; $i++) {
                    $category->subCategories()->save(
                        factory(\App\SubCategory::class)->create(['category_id' => $category->id, 'level' => $i])
                    );
                }
            });
    }
}
