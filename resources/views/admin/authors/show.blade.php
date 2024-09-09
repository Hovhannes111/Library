<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Author') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __("Edit Author:") }} {{ $author->name }}</h3>

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.authors.update', $author->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full dark:text-blue-500" value="{{ old('name', $author->name) }}" required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Birthdate</label>
                            <input type="date" name="birthdate" id="birthdate" class="mt-1 block w-full dark:text-blue-500" value="{{ old('birthdate', $author->birthdate) }}" required>
                            @error('birthdate')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                            <textarea name="bio" id="bio" rows="4" class="mt-1 block w-full dark:text-blue-500" required>{{ old('bio', $author->bio) }}</textarea>
                            @error('bio')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Changes
                            </button>
                        </div>
                    </form>
                      <h3 class="text-lg font-semibold mt-8 mb-4">{{ __("Books by:  :author", ['author' => $author->name]) }}</h3>

                      @if($author->books->count())
                          <table class="min-w-full bg-white dark:bg-gray-800">
                              <thead>
                                  <tr>
                                      <th class="py-2 px-4 border-b text-start">ID</th>
                                      <th class="py-2 px-4 border-b text-start">Title</th>
                                      <th class="py-2 px-4 border-b text-start">Published Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($author->books as $book)
                                      <tr>
                                          <td class="py-2 px-4 border-b">
                                            <a href="{{ route('admin.books.show', $book->id) }}" class="hover:text-blue-700 cursor-pointer">
                                                {{ $book->id }}
                                            </a>
                                        </td>
                                          <td class="py-2 px-4 border-b">{{ $book->title }}</td>
                                          <td class="py-2 px-4 border-b">{{ $book->published_at }}</td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      @else
                          <p class="text-gray-500">{{ __("This author has no books yet.") }}</p>
                      @endif

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.addEventListener('click', function() {
                    input.showPicker();
                });
            });
        });
    </script>
</x-app-layout>
