<?php

namespace Database\Factories;

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
        $numbers = range(1, 3);
        shuffle($numbers);
        $count = rand(1, 3);
        $categories = implode(',', array_slice($numbers, 0, $count));

        return [
            'title' => fake()->sentence(),
            'body' => fake()->text(),
            'categories' => $categories,
            'author_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
