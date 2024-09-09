<?php

namespace App\Actions\Book;

use App\Mail\BookReturnedNotification;
use App\Models\Book;
use Illuminate\Support\Facades\Mail;

class BookReturnAction
{
    public function execute(Book $book): void
    {
        $book->update([
            'status' => 'available',
        ]);
        $book->borrowedBook()->delete();
        $user = auth()->user();
        Mail::to($user->email)->queue(new BookReturnedNotification($book, $user));
        Mail::to('admin@example.com')->queue(new BookReturnedNotification($book, $user));
    }
}
