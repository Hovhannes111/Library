<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'author_id' => Author::inRandomOrder()->first()->id,
            'isbn' => fake()->unique()->isbn13(),
            'published_at' => fake()->date(),
            'status' => fake()->randomElement(['available', 'borrowed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
