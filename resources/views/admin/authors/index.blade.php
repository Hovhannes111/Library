<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Authors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">{{ __("List of Authors") }}</h3>
                        <form method="GET" action="{{ route('admin.authors.index') }}" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search authors..." class="rounded-md text-blue-500 border-blue-300 shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Search</button>
                        </form>
                    </div>
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.authors.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create Author') }}
                        </a>
                    </div>
                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="min-w-full table-auto bg-gray-100 dark:bg-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border dark:border-gray-600">#</th>
                                <th class="px-4 py-2 border dark:border-gray-600">{{ __('Name') }}</th>
                                <th class="px-4 py-2 border dark:border-gray-600">{{ __('Birthdate') }}</th>
                                <th class="px-4 py-2 border dark:border-gray-600">{{ __('Bio') }}</th>
                                <th class="px-4 py-2 border dark:border-gray-600">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($authors as $author)
                                <tr>
                                    <td class="px-4 py-2 border dark:border-gray-600">{{ $author->id }}</td>
                                    <td class="px-4 py-2 border dark:border-gray-600">{{ $author->name }}</td>
                                    <td class="px-4 py-2 border dark:border-gray-600 text-nowrap">{{ $author->birthdate }}</td>
                                    <td class="px-4 py-2 border dark:border-gray-600">{{ $author->bio }}</td>
                                    <td class="px-4 py-2 border dark:border-gray-600">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.authors.show', $author->id) }}" class="text-blue-500 hover:text-blue-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.authors.delete', $author->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this author?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    @if ($author->deleted_at)
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
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-2 border dark:border-gray-600 text-center">{{ __('No authors found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $authors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
