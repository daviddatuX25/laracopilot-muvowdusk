<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suppliers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold text-gray-800">Supplier List</h1>
                        <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Add New Supplier
                        </a>
                    </div>
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif
                    <div class="mt-6 text-gray-500">
                        <div class="mb-4">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search suppliers by name, contact, email, or phone..." class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>
                        @if ($suppliers->isEmpty())
                            <p>No suppliers found.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Contact
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $supplier->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $supplier->contact_person }}</div>
                                                    <div class="text-sm text-gray-500">{{ $supplier->email }}</div>
                                                    <div class="text-sm text-gray-500">{{ $supplier->phone }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <button wire:click="delete({{ $supplier->id }})"
                                                            wire:confirm="Are you sure you want to delete this supplier?"
                                                            class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $suppliers->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
