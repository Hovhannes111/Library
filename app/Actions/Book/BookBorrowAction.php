<?php

namespace App\Actions\Book;

use App\Mail\BookBorrowedNotification;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BookBorrowAction
{
    public function execute(Book $book): void
    {
        $user = auth()->user();
        $book->update([
            'status' => 'borrowed',
        ]);
        $book->borrowedBook()->updateOrCreate(
            ['book_id' => $book->id],
            [
                'user_id' => $user->id,
                'borrowed_at' => Carbon::now(),
            ]
        );

        Mail::to($user->email)->queue(new BookBorrowedNotification($book, $user));
        Mail::to('admin@example.com')->queue(new BookBorrowedNotification($book, $user));
    }
}
