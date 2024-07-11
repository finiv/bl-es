<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(100)->create();

         User::factory()->create([
             'name' => 'Test User',
             'email' => 'qwe@qwe.com',
             'password' => Hash::make('qweqwe'),
         ]);

        Post::factory(200)->create();
    }
}
