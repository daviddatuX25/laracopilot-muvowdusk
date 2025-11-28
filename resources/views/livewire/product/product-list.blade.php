<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-semibold text-gray-800">Product List</h1>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Add New Product
                        </a>
                    </div>
                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif
                    <div class="mt-6 text-gray-500">
                        <div class="mb-4">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products by name, SKU, or barcode..." class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>
                        @if ($products->isEmpty())
                            <p>No products found.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Image
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                SKU
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Stock
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($products as $product)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($product->image_path)
                                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-full">
                                                    @else
                                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500">N/A</div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $product->category->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $product->sku }}</div>
                                                    <div class="text-sm text-gray-500">{{ $product->barcode }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $product->current_stock }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <button wire:click="delete({{ $product->id }})"
                                                            wire:confirm="Are you sure you want to delete this product?"
                                                            class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
