<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Book\BookCreateAction;
use App\Actions\Book\BookUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    public function index(SearchRequest $searchRequest): View
    {
        $searchData = $searchRequest->validated() ? $searchRequest->validated()['search'] : '';

        $books = Book::when($searchData, function ($query, $search) {
            return $query->where('title', 'like', '%'.$search.'%');
        })->paginate(10);

        return view('admin.books.index')->with(compact('books'));
    }

    public function create(): View
    {
        $authors = Author::all();

        return view('admin.books.create')->with(compact('authors'));
    }

    public function show(Book $book): View
    {
        $authors = Author::all();
        $users = User::where('role', 'user')->get();
        $borrowedBook = $book->borrowedBook;

        return view('admin.books.show', compact('book', 'authors', 'users', 'borrowedBook'));
    }

    public function delete(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->back()->with('success', 'The book has been deleted successfully.');
    }

    public function update(
        Book $book,
        BookUpdateRequest $bookUpdateRequest,
        BookUpdateAction $bookUpdateAction
    ): RedirectResponse {
        $data = $bookUpdateRequest->validated();
        $bookUpdateAction->execute($book, $data);

        return redirect()->back()->with('success', 'The book has been updated successfully.');
    }

    public function store(
        BookCreateRequest $bookCreateRequest,
        BookCreateAction $bookCreateAction
    ): RedirectResponse {
        $data = $bookCreateRequest->validated();
        $bookCreateAction->execute($data);

        return redirect()->to('admin/books')->with('success', 'Book has been created successfully.');
    }
    
}
