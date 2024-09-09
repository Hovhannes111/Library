<?php

namespace App\Actions\Book;

use App\Models\Book;

class BookCreateAction
{
    public function execute(array $data): Book
    {
        $book = Book::create([
            'title' => $data['title'],
            'author_id' => $data['author_id'],
            'isbn' => $data['isbn'],
            'published_at' => $data['published_at'],
            'status' => 'available',
        ]);

        return $book;
    }
}
