<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Author\AuthorCreateAction;
use App\Actions\Author\AuthorUpdateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthorController extends Controller
{
    public function index(SearchRequest $searchRequest): View
    {
        $searchData = $searchRequest->validated() ? $searchRequest->validated()['search'] : '';

        $authors = Author::when($searchData, function ($query, $search) {
            return $query->where('name', 'like', '%'.$search.'%');
        })->paginate(5);

        return view('admin.authors.index', compact('authors'));
    }

    public function create(): View
    {
        return view('admin.authors.create');
    }

    public function show(Author $author): View
    {
        return view('admin.authors.show', compact('author'));
    }

    public function delete(Author $author): RedirectResponse
    {
        $author->delete();

        return redirect()->back()->with('success', 'The author has been deleted successfully.');
    }

    public function update(
        Author $author,
        AuthorUpdateRequest $authorUpdateRequest,
        AuthorUpdateAction $authorUpdateAction
    ): RedirectResponse {
        $data = $authorUpdateRequest->validated();
        $authorUpdateAction->execute($author, $data);

        return redirect()->back()->with('success', 'The author has been updated successfully.');
    }

    public function store(
        AuthorCreateRequest $authorCreateRequest,
        AuthorCreateAction $authorCreateAction
    ): RedirectResponse {
        $data = $authorCreateRequest->validated();
        $authorCreateAction->execute($data);

        return redirect()->to('admin/authors')->with('success', 'Author has been created successfully.');
    }
}
