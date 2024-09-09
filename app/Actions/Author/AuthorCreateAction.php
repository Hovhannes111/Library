<?php

namespace App\Actions\Author;

use App\Models\Author;

class AuthorCreateAction
{
    public function execute(array $data): Author
    {
        $author = Author::create([
            'name' => $data['name'],
            'birthdate' => $data['birthdate'],
            'bio' => $data['bio'],
        ]);

        return $author;
    }
}
