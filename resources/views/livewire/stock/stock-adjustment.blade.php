<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Stock Adjustment') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Adjust Stock</h1>
            </div>

            <form wire:submit.prevent="adjustStock" class="space-y-6">
                        <!-- Hidden Product ID Field -->
                        <input type="hidden" wire:model="selectedProductId" />

                        <!-- Product Selection Section -->
                        <div class="mb-6">
                            <div class="grid grid-cols-1 gap-4 mb-6">
                                <!-- Manual Search -->
                                <div class="relative z-0">
                                    <x-inventory.form.form-input-with-icon
                                        id="search"
                                        name="search"
                                        wire:model.live.debounce.300ms="search"
                                        label="Search Product"
                                        placeholder="Search by name, SKU or barcode..."
                                        icon="search"
                                    />
                                    @error('selectedProductId') <span class="text-red-500 text-xs italic mt-1 block">{{ $message }}</span> @enderror

                                    <!-- Search Results Dropdown -->
                                    @if(!empty($search) && empty($selectedProductData) && count($products) > 0)
                                        <ul class="absolute top-full left-0 right-0 mt-2 border-2 border-blue-300 rounded-lg shadow-lg bg-white overflow-hidden max-h-64 overflow-y-auto z-50">
                                            @foreach($products as $product)
                                                <li wire:click="selectProduct({{ $product['id'] }})" class="p-4 border-b last:border-b-0 hover:bg-blue-50 cursor-pointer transition flex justify-between items-center group">
                                                    <div class="flex-1">
                                                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $product['name'] }}</p>
                                                        <p class="text-xs text-gray-500">SKU: {{ $product['sku'] }}</p>
                                                    </div>
                                                    <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full">Stock: {{ $product['current_stock'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!empty($selectedProductData))
                            <!-- Selected Product Info - Better Layout -->
                            <x-inventory.card.card class="mb-8 bg-linear-to-br from-green-50 to-emerald-50 dark:from-green-900 dark:to-emerald-900 border-l-4 border-green-500">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-green-500 dark:bg-green-600 text-white px-3 py-1 rounded-full font-bold text-sm">✓ SELECTED</div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedProductData['name'] }}</h3>
                                    </div>
                                    <button type="button" wire:click="clearProductSelection" class="text-xs bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-700 dark:text-red-200 font-bold px-3 py-2 rounded transition">
                                        Change Product
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-white dark:bg-gray-800 p-4 rounded-lg">
                                    <div class="border-r border-gray-200 dark:border-gray-700 pr-4">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">SKU</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedProductData['sku'] }}</p>
                                    </div>
                                    <div class="border-r border-gray-200 dark:border-gray-700 pr-4 sm:border-r">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Current Stock</p>
                                        <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $selectedProductData['current_stock'] }}</p>
                                    </div>
                                    <div class="border-r border-gray-200 dark:border-gray-700 pr-4 sm:border-r">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Category</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedProductData['category_name'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Reorder Level</p>
                                        <p class="text-lg font-bold {{ $selectedProductData['current_stock'] <= $selectedProductData['reorder_level'] ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">{{ $selectedProductData['reorder_level'] }}</p>
                                    </div>
                                </div>
                            </x-inventory.card.card>

                            <!-- Adjustment Area -->
                            <x-inventory.card.card class="mb-8 border-2 border-gray-200 dark:border-gray-700">
                                <!-- Quantity Selection (Type auto-detected: positive = in, negative = out) -->
                                <div class="mb-8">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">1. Quantity</label>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Use + for adding stock, use − for removing stock</p>

                                    <!-- Quick Add Buttons -->
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">Quick Add:</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            <x-inventory.button.button variant="success" size="sm" type="button" wire:click="addQuantity(1)" class="w-full">+ 1</x-inventory.button.button>
                                            <x-inventory.button.button variant="success" size="sm" type="button" wire:click="addQuantity(5)" class="w-full">+ 5</x-inventory.button.button>
                                            <x-inventory.button.button variant="success" size="sm" type="button" wire:click="addQuantity(10)" class="w-full">+ 10</x-inventory.button.button>
                                        </div>
                                    </div>

                                    <!-- Current Quantity Display - Dynamic -->
                                    @if($quantity)
                                        @if($quantity > 0)
                                            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900 border-2 border-green-300 dark:border-green-700 rounded-lg text-center">
                                                <p class="text-xs font-semibold text-green-600 dark:text-green-200 uppercase">📦 Stock In</p>
                                                <p class="text-4xl font-bold text-green-600 dark:text-green-300">+{{ $quantity }}</p>
                                                <p class="text-xs text-green-600 dark:text-green-300 mt-1">Add {{ $quantity }} unit{{ $quantity != 1 ? 's' : '' }} to stock</p>
                                            </div>
                                        @else
                                            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900 border-2 border-red-300 dark:border-red-700 rounded-lg text-center">
                                                <p class="text-xs font-semibold text-red-600 dark:text-red-200 uppercase">📤 Stock Out</p>
                                                <p class="text-4xl font-bold text-red-600 dark:text-red-300">{{ $quantity }}</p>
                                                <p class="text-xs text-red-600 dark:text-red-300 mt-1">Remove {{ abs($quantity) }} unit{{ abs($quantity) != 1 ? 's' : '' }} from stock</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-center">
                                            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">⚪ Quantity</p>
                                            <p class="text-4xl font-bold text-gray-600 dark:text-gray-400">0</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Select quantity above</p>
                                        </div>
                                    @endif

                                    <!-- Quick Remove Buttons -->
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">Quick Remove:</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            <x-inventory.button.button variant="danger" size="sm" type="button" wire:click="subtractQuantity(1)" class="w-full">− 1</x-inventory.button.button>
                                            <x-inventory.button.button variant="danger" size="sm" type="button" wire:click="subtractQuantity(5)" class="w-full">− 5</x-inventory.button.button>
                                            <x-inventory.button.button variant="danger" size="sm" type="button" wire:click="subtractQuantity(10)" class="w-full">− 10</x-inventory.button.button>
                                        </div>
                                    </div>

                                    <!-- Custom Quantity Input -->
                                    <div class="flex gap-2">
                                        <x-inventory.form.form-input
                                            id="customQuantity"
                                            name="customQuantity"
                                            type="number"
                                            wire:model="customQuantity"
                                            placeholder="Or enter custom amount (use - for removal)"
                                            class="flex-1"
                                        />
                                        <x-inventory.button.button variant="primary" type="button" wire:click="updateCustomQuantity" class="mt-6">Set</x-inventory.button.button>
                                    </div>

                                    @if($quantity)
                                        <div class="mt-4 p-3 bg-indigo-50 dark:bg-indigo-900 border border-indigo-200 dark:border-indigo-700 rounded-lg">
                                            <p class="text-sm text-indigo-900 dark:text-indigo-200"><span class="font-bold">Quantity after adjustment:</span> <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ max(0, (int)($selectedProductData['current_stock'] + $quantity)) }}</span> units</p>
                                        </div>
                                    @endif
                                    @error('quantity') <span class="text-red-500 text-xs italic block mt-2">{{ $message }}</span> @enderror
                                </div>

                                <!-- Reason (Optional) -->
                                <div class="mb-8">
                                    <x-inventory.form.form-textarea
                                        id="reason"
                                        name="reason"
                                        wire:model="reason"
                                        label="2. Reason (Optional)"
                                        placeholder="e.g., Damaged stock, inventory count discrepancy, shrinkage..."
                                        rows="2"
                                    />
                                    @error('reason') <span class="text-red-500 text-xs italic block mt-2">{{ $message }}</span> @enderror
                                </div>

                                <!-- Stock Preview -->
                                @if($quantity)
                                    <div class="mb-8">
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">Stock Preview</label>
                                        @if($quantity > 0)
                                            <div class="p-4 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 dark:border-green-400 rounded-lg">
                                                <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Current:</span> <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedProductData['current_stock'] }}</span> units</p>
                                                <p class="text-sm text-green-700 dark:text-green-300 mt-2 flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-1.763 1.52a1 1 0 10-1.414-1.414l-4.242 4.242a1 1 0 001.414 1.414l4.242-4.242z" clip-rule="evenodd"/></svg>
                                                    <span><span class="font-semibold">+ {{ $quantity }}</span> units (Stock In)</span>
                                                </p>
                                                <p class="text-sm text-green-700 dark:text-green-300 mt-2"><span class="font-semibold">Result:</span> <span class="text-xl font-bold text-green-600 dark:text-green-400">{{ (int)($selectedProductData['current_stock'] + $quantity) }}</span> units</p>
                                            </div>
                                        @else
                                            <div class="p-4 bg-red-50 dark:bg-red-900 border-l-4 border-red-500 dark:border-red-400 rounded-lg">
                                                <p class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">Current:</span> <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedProductData['current_stock'] }}</span> units</p>
                                                <p class="text-sm text-red-700 dark:text-red-300 mt-2 flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 13a1 1 0 110 2h-.01a1 1 0 110-2H12zm-1.763-1.52a1 1 0 10-1.414 1.414l4.242 4.242a1 1 0 001.414-1.414l-4.242-4.242z" clip-rule="evenodd"/></svg>
                                                    <span><span class="font-semibold">- {{ abs($quantity) }}</span> units (Stock Out)</span>
                                                </p>
                                                <p class="text-sm text-red-700 dark:text-red-300 mt-2"><span class="font-semibold">Result:</span> <span class="text-xl font-bold text-red-600 dark:text-red-400">{{ max(0, (int)($selectedProductData['current_stock'] + $quantity)) }}</span> units</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </x-inventory.card.card>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <x-inventory.button.button variant="primary" type="submit" class="flex-1" :disabled="!$quantity">
                                    <span wire:loading.remove>✓ Confirm Adjustment</span>
                                    <span wire:loading>Processing...</span>
                                </x-inventory.button.button>
                                <x-inventory.button.button variant="secondary" type="button" wire:click="clearProductSelection">
                                    Cancel
                                </x-inventory.button.button>
                            </div>
                        @else
                            <x-inventory.state.empty-state
                                title="No product selected"
                                message="Please select a product above to adjust stock"
                            />
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
</div>
