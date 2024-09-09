<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user())
                <a href="{{ url('user/books') }}" class="bg-dots-darker bg-center m-2 p-5 bg-gray-400 hover:bg-gray-700 rounded text-blue-500 dark:text-blue-700">
                    Aviable books
                </a>
                <a href="{{ url('user/books/borrowed') }}" class="bg-dots-darker bg-center m-2 p-5 bg-gray-400 hover:bg-gray-700 rounded text-blue-500 dark:text-blue-700">
                    My borrowed boks
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
