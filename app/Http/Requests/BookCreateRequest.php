<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BookCreateRequest extends FormRequest
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
            'isbn' => ['required', 'string', 'max:13', 'unique:books,isbn'],
            'published_at' => ['required', 'date'],
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
        ];
    }
}
