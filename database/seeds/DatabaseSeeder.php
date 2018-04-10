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
        $this->call([
            UsersSeeder::class,
            TagsSeeder::class,
            CategoriesAndSubCategoriesSeeder::class,
            ArticlesSeeder::class,
            ContactsSeeder::class,
            WebsiteInfoSeeder::class
        ]);
    }
}
