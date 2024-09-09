<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author_id' => ['required', 'exists:authors,id'],
            'isbn' => ['required', 'string', 'max:13', 'unique:books,isbn,'.$this->route()->book->id],
            'published_at' => ['required', 'date'],
            'status' => ['required', 'in:available,borrowed'],
            'user_id' => ['nullable', 'required_if:status,borrowed'],
            'borrowed_at' => ['nullable', 'date', 'required_if:status,borrowed'],
            'returned_at' => ['nullable', 'date', 'required_if:borrowed_at,!null', 'after_or_equal:borrowed_at'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'author_id.required' => 'Please select an author.',
            'isbn.required' => 'The ISBN is required.',
            'isbn.unique' => 'This ISBN already exists.',
            'published_at.required' => 'The publication date is required.',
            'status.required' => 'The status is required.',
            'user_id.required_if' => 'Please select a user if the book is borrowed.',
            'borrowed_at.required_if' => 'Please provide the borrowed date if the book is borrowed.',
            'returned_at.after_or_equal' => 'The return date cannot be earlier than the borrowed date.',
        ];
    }
}
