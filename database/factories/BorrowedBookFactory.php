<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BorrowedBook>
 */
class BorrowedBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id,
            'book_id' => null,
            'borrowed_at' => now(),
            'returned_at' => null,
        ];
    }

    public function createForBorrowedBooks(): void
    {
        $borrowedBooks = Book::where('status', 'borrowed')->get();

        foreach ($borrowedBooks as $book) {
            BorrowedBook::factory()->create([
                'book_id' => $book->id,
            ]);
        }
    }
}
