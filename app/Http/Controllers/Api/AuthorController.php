<?php

namespace App\Http\Controllers\Api;

use App\Actions\Author\AuthorCreateAction;
use App\Actions\Author\AuthorUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    public function index(): JsonResponse
    {
        $authors = Author::paginate(10);

        return response()->json($authors);
    }

    public function store(
        AuthorCreateRequest $authorCreateRequest,
        AuthorCreateAction $authorCreateAction
    ): JsonResponse {
        $data = $authorCreateRequest->validated();
        $author = $authorCreateAction->execute($data);

        return response()->json($author, 201);
    }

    public function show(Author $author): JsonResponse
    {
        return response()->json($author);
    }

    public function update(
        Author $author,
        AuthorUpdateRequest $authorUpdateRequest,
        AuthorUpdateAction $authorUpdateAction
    ): JsonResponse {
        $data = $authorUpdateRequest->validated();
        $authorUpdateAction->execute($author, $data);

        return response()->json($author);
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'The author has been deleted successfully.',
        ], 202);
    }
}
