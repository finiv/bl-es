<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryIds = Category::pluck('id')->toArray();
        shuffle($categoryIds);
        $count = rand(1, 3);
        $categories = json_encode(array_slice($categoryIds, 0, $count));

        return [
            'title' => fake()->sentence(),
            'body' => fake()->text(),
            'categories' => $categories,
            'author_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
