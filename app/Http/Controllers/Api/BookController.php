<?php

namespace App\Http\Controllers\Api;

use App\Actions\Book\BookCreateAction;
use App\Actions\Book\BookUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        $books = Book::paginate(10);

        return response()->json($books);
    }

    public function store(
        BookCreateRequest $bookCreateRequest,
        BookCreateAction $bookCreateAction
    ): JsonResponse {
        $data = $bookCreateRequest->validated();
        $book = $bookCreateAction->execute($data);

        return response()->json($book, 201);
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json($book);
    }

    public function update(
        Book $book,
        BookUpdateRequest $bookUpdateRequest,
        BookUpdateAction $bookUpdateAction
    ): JsonResponse {
        $data = $bookUpdateRequest->validated();
        $bookUpdateAction->execute($book, $data);

        return response()->json($book);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'The book has been deleted successfully.',
        ], 202);
    }
}
