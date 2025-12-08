<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-violet-100 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card class="overflow-hidden">
                <div class="p-6 sm:px-20">
                    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Edit Product</h1>

                    <form wire:submit.prevent="update" class="mt-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-inventory.form.form-input
                                id="name"
                                name="name"
                                wire:model.lazy="name"
                                label="Product Name"
                            />
                            <x-inventory.form.form-input
                                id="sku"
                                name="sku"
                                wire:model="sku"
                                label="SKU"
                                hint="(optional)"
                            />
                            <x-inventory.form.form-input
                                id="barcode"
                                name="barcode"
                                wire:model="barcode"
                                label="Barcode"
                                hint="(optional)"
                            />
                            <x-inventory.form.form-select
                                id="category_id"
                                name="category_id"
                                wire:model="category_id"
                                label="Category"
                                hint="(optional)"
                            >
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category_id == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </x-inventory.form.form-select>
                            <x-inventory.form.form-select
                                id="supplier_id"
                                name="supplier_id"
                                wire:model="supplier_id"
                                label="Supplier"
                                hint="(optional)"
                            >
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" @selected($supplier_id == $supplier->id)>{{ $supplier->name }}</option>
                                @endforeach
                            </x-inventory.form.form-select>
                            <x-inventory.form.form-input
                                id="cost_price"
                                name="cost_price"
                                type="number"
                                step="0.01"
                                wire:model="cost_price"
                                label="Cost Price (₱)"
                            />
                            <x-inventory.form.form-input
                                id="selling_price"
                                name="selling_price"
                                type="number"
                                step="0.01"
                                wire:model="selling_price"
                                label="Selling Price (₱)"
                            />
                            <x-inventory.form.form-input
                                id="reorder_level"
                                name="reorder_level"
                                type="number"
                                wire:model="reorder_level"
                                label="Reorder Level"
                            />
                            <x-inventory.form.form-input
                                id="current_stock"
                                name="current_stock"
                                type="number"
                                wire:model="current_stock"
                                label="Current Stock"
                            />
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Image <span class="text-gray-500 dark:text-gray-400">(optional)</span></label>
                                <input type="file" id="image" wire:model="image" accept="image/*;capture=environment" class="appearance-none block w-full px-4 py-2 border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">📷 Tap on mobile to take a photo or upload an image</p>
                                @error('image') <span class="text-red-500 dark:text-red-400 text-xs italic block mt-2">{{ $message }}</span> @enderror

                                @if ($image)
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Image Preview:</p>
                                        <img src="{{ $image->temporaryUrl() }}" alt="New Product Image Preview" class="w-32 h-32 object-cover rounded-lg shadow-md">
                                    </div>
                                @elseif ($old_image_path)
                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Image:</p>
                                        <img src="{{ asset('storage/' . $old_image_path) }}" alt="Current Product Image" class="w-32 h-32 object-cover rounded-lg shadow-md">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <x-inventory.form.form-textarea
                            id="description"
                            name="description"
                            wire:model="description"
                            label="Description"
                            rows="3"
                        />

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-indigo-500 transition">
                                Cancel
                            </a>
                            <x-inventory.button.button variant="primary" type="submit">
                                Update Product
                            </x-inventory.button.button>
                        </div>
                    </form>
                </div>
            </x-inventory.card.card>
        </div>
    </div>
</div>
