<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __("Edit Book:") }} {{ $book->title }}</h3>

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full dark:text-blue-500" value="{{ old('title', $book->title) }}" required>
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="author_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Author</label>
                            <select name="author_id" id="author_id" class="mt-1 block w-full dark:text-blue-500">
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="isbn" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="mt-1 block w-full dark:text-blue-500" value="{{ old('isbn', $book->isbn) }}" required>
                            @error('isbn')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Published At</label>
                            <input type="date" name="published_at" id="published_at" class="mt-1 block w-full dark:text-blue-500" value="{{ old('published_at', $book->published_at) }}" required>
                            @error('published_at')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full dark:text-blue-500">
                                <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="borrowed" {{ $book->status == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4" id="borrowed-user" style="{{ $book->status === 'borrowed' ? 'display: block;' : 'display: none;' }}">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Borrowed By</label>
                            <select name="user_id" id="user_id" class="mt-1 block w-full dark:text-blue-500">
                                <option value="null" selected>Select</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $borrowedBook && $borrowedBook->user_id && $borrowedBook->user_id == $user->id ? 'selected' : '') }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4" id="borrowed-at" style="{{ $book->status === 'borrowed' ? 'display: block;' : 'display: none;' }}">
                            <label for="borrowed_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Borrowed At</label>
                            <input type="date" name="borrowed_at" id="borrowed_at" class="mt-1 block w-full dark:text-blue-500" value="{{ old('borrowed_at', $borrowedBook && $borrowedBook->borrowed_at ? date('Y-m-d', strtotime($borrowedBook->borrowed_at)) : '') }}">
                            @error('borrowed_at')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="borrowed_at_hidden" value="{{ old('borrowed_at', $borrowedBook && $borrowedBook->borrowed_at ? date('Y-m-d', strtotime($borrowedBook->borrowed_at)) : '') }}">
                        
                        <div class="mb-4" id="returned-at" style="{{ $book->status === 'borrowed' ? 'display: block;' : 'display: none;' }}">
                            <label for="returned_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Returned At</label>
                            <input type="date" name="returned_at" id="returned_at" class="mt-1 block w-full dark:text-blue-500" value="{{ old('returned_at', $borrowedBook && $borrowedBook->returned_at ? date('Y-m-d', strtotime($borrowedBook->returned_at)) : '') }}" {{ $borrowedBook && $borrowedBook->returned_at ? 'disabled' : '' }}>
                            @error('returned_at')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const borrowedUserDiv = document.getElementById('borrowed-user');
            const borrowedAtDiv = document.getElementById('borrowed-at');
            const returnedAtDiv = document.getElementById('returned-at');

            function toggleFields() {
                if (statusSelect.value === 'borrowed') {
                    borrowedUserDiv.style.display = 'block';
                    borrowedAtDiv.style.display = 'block';
                    returnedAtDiv.style.display = 'block';
                } else {
                    borrowedUserDiv.style.display = 'none';
                    borrowedAtDiv.style.display = 'none';
                    returnedAtDiv.style.display = 'none';
                }
            }

            toggleFields();
            statusSelect.addEventListener('change', toggleFields);

            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.addEventListener('click', function() {
                    input.showPicker();
                });
            });
        });
    </script>
</x-app-layout>
