<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">
                        <h1 class="text-2xl font-semibold text-gray-800">Category List</h1>
                        <div class="flex gap-3">
                            <button wire:click="toggleView" class="inline-flex items-center px-3 py-2 bg-blue-50 border border-blue-200 rounded-md font-medium text-xs text-blue-600 hover:bg-blue-100 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4H5a2 2 0 00-2 2v14a2 2 0 002 2h4m0-18v18m0-18l10-4v18l-10 4M19 5l-7 4m0 6l7-4"></path>
                                </svg>
                                {{ $viewMode === 'table' ? 'Card View' : 'Table View' }}
                            </button>
                            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Add New Category
                            </a>
                        </div>
                    </div>
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif
                    <div class="mt-6 text-gray-500">
                        <div class="relative mb-4">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search categories by name or description..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                        </div>
                        @if ($categories->isEmpty())
                            <p>No categories found.</p>
                        @else
                            <!-- Table view -->
                            @if ($viewMode === 'table')
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Name
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Description
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-500">{{ $category->description }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                        <button wire:click="delete({{ $category->id }})"
                                                                wire:confirm="Are you sure you want to delete this category?"
                                                                class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <!-- Card view -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($categories as $category)
                                        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-4 hover:shadow-lg transition">
                                            <div class="mb-3">
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                                            </div>

                                            <div class="mb-4">
                                                <p class="text-sm text-gray-600 line-clamp-3">{{ $category->description ?? 'No description available' }}</p>
                                            </div>

                                            <div class="flex gap-2 pt-3 border-t border-gray-200">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-indigo-50 text-indigo-600 rounded-md font-medium text-sm hover:bg-indigo-100 transition">
                                                    Edit
                                                </a>
                                                <button wire:click="delete({{ $category->id }})"
                                                        wire:confirm="Are you sure you want to delete this category?"
                                                        class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-50 text-red-600 rounded-md font-medium text-sm hover:bg-red-100 transition">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-4">
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
