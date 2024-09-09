<?php

namespace App\Actions\Author;

use App\Models\Author;

class AuthorUpdateAction
{
    public function execute(Author $author, array $data): void
    {
        $author->update([
            'name' => $data['name'],
            'birthdate' => $data['birthdate'],
            'bio' => $data['bio'],
        ]);

    }
}
