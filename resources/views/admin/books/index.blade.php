<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">{{ __("Books List") }}</h3>
                        <form method="GET" action="{{ route('admin.books.index') }}" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." class="text-blue-500 rounded-md border-blue-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                        </form>
                    </div>
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create Book') }}
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">ISBN</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr 
                                    @if ($book->deleted_at)
                                        class="bg-red-500"   
                                    @endif
                                >
                                    <td class="border px-4 py-2">{{ $book->id }}</td>
                                    <td class="border px-4 py-2 text-sm truncate max-w-xs">{{ $book->title }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.authors.show', $book->author->id) }}" class="transition-opacity hover:text-sky-500">
                                            {{ $book->author->name }}
                                        </a>
                                    </td>
                                    <td class="border px-4 py-2">{{ $book->isbn }}</td>
                                    <td class="border px-4 py-2">{{ $book->status }}</td>
                                    <td class="border px-4 py-2">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.books.show', $book->id) }}" class="text-blue-500 hover:text-blue-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.books.delete', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    @if ($book->deleted_at)
                                                        class="text-white-500 hover:text-zinc-950"
                                                    @else   
                                                        class="text-red-500 hover:text-red-700"
                                                    @endif    
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
