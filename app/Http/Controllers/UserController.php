<?php

namespace App\Http\Controllers;

use App\Actions\Book\BookBorrowAction;
use App\Actions\Book\BookReturnAction;
use App\Http\Requests\SearchRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BorrowedBook;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function index(SearchRequest $searchRequest): View
    {
        $searchData = $searchRequest->validated() ? $searchRequest->validated()['search'] : '';

        $books = Book::when($searchData, function ($query, $search) {
            return $query->where('title', 'like', '%'.$search.'%');
        })->available()->paginate(10);

        return view('user.books.index')->with(compact('books'));
    }

    public function author(Author $author): View
    {
        $books = Book::where('author_id', $author->id)->available()->paginate(10);

        return view('user.books.index')->with(compact('books'));
    }

    public function borrowBooks(): View
    {
        $books = BorrowedBook::where('user_id', auth()->user()->id)->paginate(10);

        return view('user.books.borrowed')->with(compact('books'));
    }

    public function borrow(
        Book $book,
        BookBorrowAction $bookBorrowAction
    ): RedirectResponse {
        $bookBorrowAction->execute($book);

        return redirect()->back()->with('success', 'The book has been borrowed.');
    }

    public function return(
        Book $book,
        BookReturnAction $bookReturnAction
    ): RedirectResponse {
        $bookReturnAction->execute($book);

        return redirect()->back()->with('success', 'The book has been returned.');
    }
}
