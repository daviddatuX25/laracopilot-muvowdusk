<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Adjustment') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Adjust Stock</h1>
            </div>

            <form wire:submit.prevent="adjustStock" class="space-y-6">
                        <!-- Hidden Product ID Field -->
                        <input type="hidden" wire:model="selectedProductId" />

                        <!-- Product Selection Section -->
                        <div class="mb-6">
                            <div class="grid grid-cols-1 gap-4 mb-6">
                                <!-- Manual Search -->
                                <div class="relative z-0">
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Search Product</label>
                                    <input type="text"
                                        id="search"
                                        wire:model.live.debounce.300ms="search"
                                        placeholder="Search by name, SKU or barcode..."
                                        @keydown.enter.prevent
                                        class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-lg shadow-sm font-medium placeholder-gray-400 transition duration-200">
                                    @error('selectedProductId') <span class="text-red-500 text-xs italic mt-1 block">{{ $message }}</span> @enderror

                                    <!-- Search Results Dropdown -->
                                    @if(!empty($search) && !$selectedProduct && count($products) > 0)
                                        <ul class="absolute top-full left-0 right-0 mt-2 border-2 border-blue-300 rounded-lg shadow-lg bg-white overflow-hidden max-h-64 overflow-y-auto z-50">
                                            @foreach($products as $product)
                                                <li wire:click="selectProduct({{ $product->id }})" class="p-4 border-b last:border-b-0 hover:bg-blue-50 cursor-pointer transition flex justify-between items-center group">
                                                    <div class="flex-1">
                                                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $product->name }}</p>
                                                        <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                                                    </div>
                                                    <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full">Stock: {{ $product->current_stock }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($selectedProduct)
                            <!-- Selected Product Info - Better Layout -->
                            <div class="mb-8 p-5 bg-gradient-to-br from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-md">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-green-500 text-white px-3 py-1 rounded-full font-bold text-sm">✓ SELECTED</div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $selectedProduct->name }}</h3>
                                    </div>
                                    <button type="button" wire:click="clearProductSelection" class="text-xs bg-red-100 hover:bg-red-200 text-red-700 font-bold px-3 py-2 rounded transition">
                                        Change Product
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-white p-4 rounded-lg">
                                    <div class="border-r border-gray-200 pr-4">
                                        <p class="text-xs font-semibold text-gray-500 uppercase">SKU</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $selectedProduct->sku }}</p>
                                    </div>
                                    <div class="border-r border-gray-200 pr-4 sm:border-r">
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Current Stock</p>
                                        <p class="text-lg font-bold text-blue-600">{{ $selectedProduct->current_stock }}</p>
                                    </div>
                                    <div class="border-r border-gray-200 pr-4 sm:border-r">
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Category</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $selectedProduct->category->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase">Reorder Level</p>
                                        <p class="text-lg font-bold {{ $selectedProduct->current_stock <= $selectedProduct->reorder_level ? 'text-red-600' : 'text-green-600' }}">{{ $selectedProduct->reorder_level }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Adjustment Area - Improved Layout -->
                            <div class="bg-white rounded-lg border-2 border-gray-200 p-6 shadow-lg">
                                <!-- Quantity Selection (Type auto-detected: positive = in, negative = out) -->
                                <div class="mb-8">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">1. Quantity</label>
                                    <p class="text-xs text-gray-600 mb-4">Use + for adding stock, use − for removing stock</p>

                                    <!-- Quick Add Buttons -->
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-600 mb-2">Quick Add:</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            <button type="button" wire:click="addQuantity(1)" class="p-2 bg-green-100 hover:bg-green-200 text-green-700 border border-green-300 font-bold text-sm rounded-lg transition">
                                                <span class="text-lg">+</span> 1
                                            </button>
                                            <button type="button" wire:click="addQuantity(5)" class="p-2 bg-green-100 hover:bg-green-200 text-green-700 border border-green-300 font-bold text-sm rounded-lg transition">
                                                <span class="text-lg">+</span> 5
                                            </button>
                                            <button type="button" wire:click="addQuantity(10)" class="p-2 bg-green-100 hover:bg-green-200 text-green-700 border border-green-300 font-bold text-sm rounded-lg transition">
                                                <span class="text-lg">+</span> 10
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Current Quantity Display - Dynamic -->
                                    @if($quantity)
                                        @if($quantity > 0)
                                            <div class="mb-4 p-4 bg-green-50 border-2 border-green-300 rounded-lg text-center">
                                                <p class="text-xs font-semibold text-green-600 uppercase">📦 Stock In</p>
                                                <p class="text-4xl font-bold text-green-600">+{{ $quantity }}</p>
                                                <p class="text-xs text-green-600 mt-1">Add {{ $quantity }} unit{{ $quantity != 1 ? 's' : '' }} to stock</p>
                                            </div>
                                        @else
                                            <div class="mb-4 p-4 bg-red-50 border-2 border-red-300 rounded-lg text-center">
                                                <p class="text-xs font-semibold text-red-600 uppercase">📤 Stock Out</p>
                                                <p class="text-4xl font-bold text-red-600">{{ $quantity }}</p>
                                                <p class="text-xs text-red-600 mt-1">Remove {{ abs($quantity) }} unit{{ abs($quantity) != 1 ? 's' : '' }} from stock</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mb-4 p-4 bg-gray-50 border-2 border-gray-300 rounded-lg text-center">
                                            <p class="text-xs font-semibold text-gray-600 uppercase">⚪ Quantity</p>
                                            <p class="text-4xl font-bold text-gray-600">0</p>
                                            <p class="text-xs text-gray-600 mt-1">Select quantity above</p>
                                        </div>
                                    @endif

                                    <!-- Quick Remove Buttons -->
                                    <div class="mb-4">
                                        <p class="text-xs font-semibold text-gray-600 mb-2">Quick Remove:</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            <button type="button" wire:click="subtractQuantity(1)" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 border border-red-300 font-bold text-sm rounded-lg transition">
                                                <span class="text-lg">−</span> 1
                                            </button>
                                            <button type="button" wire:click="subtractQuantity(5)" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 border border-red-300 font-bold text-sm rounded-lg transition">
                                                <span class="text-lg">−</span> 5
                                            </button>
                                            <button type="button" wire:click="subtractQuantity(10)" class="p-2 bg-red-100 hover:bg-red-200 text-red-700 border border-red-300 font-bold text-sm rounded-lg transition">
                                                <span class="text-lg">−</span> 10
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Custom Quantity Input -->
                                    <div class="flex gap-2">
                                        <input type="number" id="customQuantity" wire:model="customQuantity" placeholder="Or enter custom amount (use - for removal)" class="flex-1 px-4 py-3 border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 rounded-lg font-medium transition duration-200">
                                        <button type="button" wire:click="updateCustomQuantity" class="px-5 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105">
                                            Set
                                        </button>
                                        <button type="button" wire:click="resetQuantity" class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition">
                                            Clear
                                        </button>
                                    </div>

                                    @if($quantity)
                                        <div class="mt-4 p-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                                            <p class="text-sm"><span class="font-bold text-indigo-700">Quantity after adjustment:</span> <span class="text-lg font-bold text-indigo-600">{{ max(0, (int)($selectedProduct->current_stock + $quantity)) }}</span> units</p>
                                        </div>
                                    @endif
                                    @error('quantity') <span class="text-red-500 text-xs italic block mt-2">{{ $message }}</span> @enderror
                                </div>

                                <!-- Reason (Optional) -->
                                <div class="mb-8">
                                    <label for="reason" class="block text-sm font-bold text-gray-700 mb-4">2. Reason (Optional)</label>
                                    <textarea id="reason" wire:model="reason" placeholder="e.g., Damaged stock, inventory count discrepancy, shrinkage..." class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 rounded-lg font-medium transition duration-200" rows="2"></textarea>
                                    @error('reason') <span class="text-red-500 text-xs italic block mt-2">{{ $message }}</span> @enderror
                                </div>

                                <!-- Stock Preview -->
                                @if($quantity)
                                    <div class="mb-8">
                                        <label class="block text-sm font-bold text-gray-700 mb-4">Stock Preview</label>
                                        @if($quantity > 0)
                                            <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                                                <p class="text-sm text-gray-700"><span class="font-semibold">Current:</span> <span class="text-lg font-bold text-gray-900">{{ $selectedProduct->current_stock }}</span> units</p>
                                                <p class="text-sm text-green-700 mt-2 flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h.01a1 1 0 110 2H12zm-1.763 1.52a1 1 0 10-1.414-1.414l-4.242 4.242a1 1 0 001.414 1.414l4.242-4.242z" clip-rule="evenodd"/></svg>
                                                    <span><span class="font-semibold">+ {{ $quantity }}</span> units (Stock In)</span>
                                                </p>
                                                <p class="text-sm text-green-700 mt-2"><span class="font-semibold">Result:</span> <span class="text-xl font-bold text-green-600">{{ (int)($selectedProduct->current_stock + $quantity) }}</span> units</p>
                                            </div>
                                        @else
                                            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                                                <p class="text-sm text-gray-700"><span class="font-semibold">Current:</span> <span class="text-lg font-bold text-gray-900">{{ $selectedProduct->current_stock }}</span> units</p>
                                                <p class="text-sm text-red-700 mt-2 flex items-center gap-2">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 13a1 1 0 110 2h-.01a1 1 0 110-2H12zm-1.763-1.52a1 1 0 10-1.414 1.414l4.242 4.242a1 1 0 001.414-1.414l-4.242-4.242z" clip-rule="evenodd"/></svg>
                                                    <span><span class="font-semibold">- {{ abs($quantity) }}</span> units (Stock Out)</span>
                                                </p>
                                                <p class="text-sm text-red-700 mt-2"><span class="font-semibold">Result:</span> <span class="text-xl font-bold text-red-600">{{ max(0, (int)($selectedProduct->current_stock + $quantity)) }}</span> units</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                                <button type="submit" wire:click="adjustStock" class="flex-1 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition" {{ !$quantity ? 'disabled' : '' }}>
                                    <span wire:loading.remove>✓ Confirm Adjustment</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button type="button" wire:click="clearProductSelection" class="px-6 py-3 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 font-bold rounded-lg transition">
                                    Cancel
                                </button>
                            </div>
                        @else
                            <div class="p-6 bg-gray-50 rounded-lg text-center text-gray-600">
                                <p class="text-lg font-semibold">Please select a product to adjust stock</p>
                            </div>
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
