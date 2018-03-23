<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
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
    }
}
