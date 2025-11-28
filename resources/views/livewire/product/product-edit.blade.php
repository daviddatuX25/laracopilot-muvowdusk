<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800">Edit Product</h1>

                    <form wire:submit.prevent="update" class="mt-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <div class="mt-1">
                                    <input type="text" id="name" wire:model.lazy="name" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                                <div class="mt-1">
                                    <input type="text" id="sku" wire:model="sku" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('sku') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode (optional)</label>
                                <div class="mt-1">
                                    <input type="text" id="barcode" wire:model="barcode" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('barcode') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                <div class="mt-1">
                                    <select id="category_id" wire:model="category_id" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @selected($category_id == $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                <div class="mt-1">
                                    <select id="supplier_id" wire:model="supplier_id" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" @selected($supplier_id == $supplier->id)>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('supplier_id') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="cost_price" class="block text-sm font-medium text-gray-700">Cost Price</label>
                                <div class="mt-1">
                                    <input type="number" step="0.01" id="cost_price" wire:model="cost_price" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('cost_price') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="selling_price" class="block text-sm font-medium text-gray-700">Selling Price</label>
                                <div class="mt-1">
                                    <input type="number" step="0.01" id="selling_price" wire:model="selling_price" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('selling_price') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="reorder_level" class="block text-sm font-medium text-gray-700">Reorder Level</label>
                                <div class="mt-1">
                                    <input type="number" id="reorder_level" wire:model="reorder_level" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('reorder_level') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="current_stock" class="block text-sm font-medium text-gray-700">Current Stock</label>
                                <div class="mt-1">
                                    <input type="number" id="current_stock" wire:model="current_stock" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('current_stock') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Product Image (optional)</label>
                                <div class="mt-1">
                                    <input type="file" id="image" wire:model="image" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('image') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                                @if ($old_image_path)
                                    <p class="text-sm text-gray-500 mt-2">Current Image:</p>
                                    <img src="{{ asset('storage/' . $old_image_path) }}" alt="Current Product Image" class="w-20 h-20 object-cover rounded-full mt-1">
                                @endif
                                @if ($image)
                                    <p class="text-sm text-gray-500 mt-2">New Image Preview:</p>
                                    <img src="{{ $image->temporaryUrl() }}" alt="New Product Image Preview" class="w-20 h-20 object-cover rounded-full mt-1">
                                @endif
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <div class="mt-1">
                                <textarea id="description" wire:model="description" rows="3" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                            @error('description') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
