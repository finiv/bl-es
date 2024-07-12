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
        User::factory(100)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'qwe@qwe.com',
            'password' => Hash::make('qweqwe'),
        ]);

        $this->call(CategorySeeder::class);
        Post::factory(200)->create();
    }
}
