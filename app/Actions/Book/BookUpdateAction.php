<?php

namespace App\Actions\Book;

use App\Mail\BookBorrowedNotification;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class BookUpdateAction
{
    public function execute(Book $book, array $data): void
    {
        $status = $data['status'];
        $returnedAt = $data['returned_at'] ?? null;
        $borrowedAt = $data['borrowed_at'] ?? null;
        if ($returnedAt && $borrowedAt) {
            $status = 'available';
        }
        $book->update([
            'title' => $data['title'],
            'author_id' => $data['author_id'],
            'isbn' => $data['isbn'],
            'published_at' => $data['published_at'],
            'status' => $status,
        ]);

        if ($status == 'available' && $book->borrowedBook) {
            $book->borrowedBook->delete();
        }
        if ($status != 'available' && (int) $data['user_id']) {
            $book->borrowedBook()->updateOrCreate(
                ['book_id' => $book->id],
                [
                    'user_id' => $data['user_id'],
                    'borrowed_at' => $borrowedAt,
                    'returned_at' => $returnedAt,
                ]
            );
            $user = User::find($data['user_id']);
            if ($user) {
                Mail::to($user->email)->queue(new BookBorrowedNotification($book, $user));
            }
            Mail::to('admin@example.com')->queue(new BookBorrowedNotification($book, $user));
        }

    }
}
