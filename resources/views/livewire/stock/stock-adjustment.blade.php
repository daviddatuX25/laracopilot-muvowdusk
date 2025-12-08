<div class="min-h-screen bg-linear-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8">
    <x-slot name="header">
        <h2 class="font-semibold text-white dark:text-violet-100 leading-tight">
            {{ __('Stock Adjustment') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Adjust Stock</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage product inventory with precise control over stock movements</p>
        </div>

        <form wire:submit.prevent="adjustStock" class="space-y-6">
            <!-- Hidden Fields -->
            <input type="hidden" wire:model="selectedProductId" />
            <input type="hidden" wire:model="isAdjustment" />

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Product Selection & Input -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Search Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="mb-4">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Select Product
                            </h2>
                        </div>
                        <div class="relative z-20">
                            <x-inventory.form.form-input-with-icon
                                id="search"
                                name="search"
                                wire:model.live.debounce.300ms="search"
                                label="Search Products"
                                placeholder="Search by name, SKU or barcode..."
                                icon="search"
                            />
                            @error('selectedProductId') <span class="text-red-500 text-xs italic mt-2 block">{{ $message }}</span> @enderror

                            <!-- Search Results Dropdown -->
                            @if(!empty($search) && empty($selectedProductData) && count($products) > 0)
                                <ul class="absolute top-full left-0 right-0 mt-2 border border-gray-200 dark:border-gray-600 rounded-lg shadow-xl bg-white dark:bg-gray-800 overflow-hidden max-h-72 overflow-y-auto z-50">
                                    @foreach($products as $product)
                                        <li wire:click="selectProduct({{ $product['id'] }})" class="p-4 border-b border-gray-100 dark:border-gray-700 last:border-b-0 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition flex justify-between items-center group">
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">{{ $product['name'] }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">SKU: <span class="font-mono">{{ $product['sku'] }}</span></p>
                                            </div>
                                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold px-3 py-1 rounded-lg ml-2 whitespace-nowrap">{{ $product['current_stock'] }} units</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    @if(!empty($selectedProductData))
                        <!-- Product Info Card -->
                        <div class="bg-linear-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-xl shadow-sm border border-blue-200 dark:border-blue-800 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="bg-blue-600 dark:bg-blue-500 text-white p-2 rounded-lg">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wide">Product Selected</p>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $selectedProductData['name'] }}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div class="bg-white dark:bg-gray-800/50 p-3 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">SKU</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white font-mono">{{ $selectedProductData['sku'] }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800/50 p-3 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Current</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $selectedProductData['current_stock'] }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800/50 p-3 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Category</p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $selectedProductData['category_name'] ?? 'N/A' }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800/50 p-3 rounded-lg">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Reorder</p>
                                    <p class="text-lg font-bold {{ $selectedProductData['current_stock'] <= $selectedProductData['reorder_level'] ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">{{ $selectedProductData['reorder_level'] }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Adjustment Type & Quantity -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                            <!-- Toggle -->
                            <div class="flex items-center justify-between p-4 bg-linear-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/30 dark:to-blue-900/30 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">Adjustment Mode</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Toggle to record as inventory adjustment</p>
                                </div>
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" wire:model.live="isAdjustment" class="sr-only peer">
                                        <div class="w-12 h-7 bg-gray-300 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all dark:peer-checked:bg-blue-600 peer-checked:bg-blue-600"></div>
                                    </div>
                                </label>
                            </div>

                            <!-- Quantity Section -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    Quantity
                                </h3>

                                <!-- Quick Buttons -->
                                <div class="grid grid-cols-6 gap-2 mb-4">
                                    <button type="button" wire:click="addQuantity(1)" class="col-span-1 px-3 py-2 border-2 border-green-300/50 dark:border-green-800/50 bg-green-50/30 dark:bg-green-900/10 text-green-700 dark:text-green-300 font-semibold rounded-lg hover:bg-green-100/50 dark:hover:bg-green-900/20 transition text-sm backdrop-blur-sm">+1</button>
                                    <button type="button" wire:click="addQuantity(5)" class="col-span-1 px-3 py-2 border-2 border-green-300/50 dark:border-green-800/50 bg-green-50/30 dark:bg-green-900/10 text-green-700 dark:text-green-300 font-semibold rounded-lg hover:bg-green-100/50 dark:hover:bg-green-900/20 transition text-sm backdrop-blur-sm">+5</button>
                                    <button type="button" wire:click="addQuantity(10)" class="col-span-1 px-3 py-2 border-2 border-green-300/50 dark:border-green-800/50 bg-green-50/30 dark:bg-green-900/10 text-green-700 dark:text-green-300 font-semibold rounded-lg hover:bg-green-100/50 dark:hover:bg-green-900/20 transition text-sm backdrop-blur-sm">+10</button>
                                    <button type="button" wire:click="subtractQuantity(1)" class="col-span-1 px-3 py-2 border-2 border-red-300/50 dark:border-red-800/50 bg-red-50/30 dark:bg-red-900/10 text-red-700 dark:text-red-300 font-semibold rounded-lg hover:bg-red-100/50 dark:hover:bg-red-900/20 transition text-sm backdrop-blur-sm">−1</button>
                                    <button type="button" wire:click="subtractQuantity(5)" class="col-span-1 px-3 py-2 border-2 border-red-300/50 dark:border-red-800/50 bg-red-50/30 dark:bg-red-900/10 text-red-700 dark:text-red-300 font-semibold rounded-lg hover:bg-red-100/50 dark:hover:bg-red-900/20 transition text-sm backdrop-blur-sm">−5</button>
                                    <button type="button" wire:click="subtractQuantity(10)" class="col-span-1 px-3 py-2 border-2 border-red-300/50 dark:border-red-800/50 bg-red-50/30 dark:bg-red-900/10 text-red-700 dark:text-red-300 font-semibold rounded-lg hover:bg-red-100/50 dark:hover:bg-red-900/20 transition text-sm backdrop-blur-sm">−10</button>
                                </div>

                                <!-- Quantity Status Display -->
                                @if($quantity)
                                    @if($isAdjustment)
                                        <div class="p-4 bg-indigo-50 dark:bg-indigo-900/30 border-2 border-indigo-300 dark:border-indigo-700 rounded-lg text-center">
                                            <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase">↻ Inventory Adjustment</p>
                                            <p class="text-5xl font-black text-indigo-600 dark:text-indigo-400 mt-2">{{ $quantity > 0 ? '+' : '' }}{{ $quantity }}</p>
                                            <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-2">{{ $quantity > 0 ? 'Increase' : 'Decrease' }} by {{ abs($quantity) }} unit{{ abs($quantity) != 1 ? 's' : '' }}</p>
                                        </div>
                                    @elseif($quantity > 0)
                                        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/30 border-2 border-emerald-300 dark:border-emerald-700 rounded-lg text-center">
                                            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase">📦 Stock In</p>
                                            <p class="text-5xl font-black text-emerald-600 dark:text-emerald-400 mt-2">+{{ $quantity }}</p>
                                            <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-2">Add {{ $quantity }} unit{{ $quantity != 1 ? 's' : '' }} to inventory</p>
                                        </div>
                                    @else
                                        <div class="p-4 bg-rose-50 dark:bg-rose-900/30 border-2 border-rose-300 dark:border-rose-700 rounded-lg text-center">
                                            <p class="text-xs font-semibold text-rose-600 dark:text-rose-400 uppercase">📤 Stock Out</p>
                                            <p class="text-5xl font-black text-rose-600 dark:text-rose-400 mt-2">{{ $quantity }}</p>
                                            <p class="text-sm text-rose-600 dark:text-rose-400 mt-2">Remove {{ abs($quantity) }} unit{{ abs($quantity) != 1 ? 's' : '' }} from inventory</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="p-4 bg-gray-100 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-center">
                                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">⚪ No Quantity</p>
                                        <p class="text-3xl font-bold text-gray-400 dark:text-gray-500 mt-2">0</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Select quantity using buttons or input below</p>
                                    </div>
                                @endif

                                <!-- Custom Input -->
                                <div class="flex gap-2 mt-4 ml-auto w-fit items-center">
                                    <x-inventory.form.form-input
                                        id="customQuantity"
                                        name="customQuantity"
                                        type="number"
                                        wire:model="customQuantity"
                                        placeholder="Custom amount"
                                        class="w-40"
                                    />
                                    <button type="button" wire:click="updateCustomQuantity" class="px-6 py-2 border-2 mb-4 border-blue-300/50 dark:border-blue-800/50 bg-blue-50/30 dark:bg-blue-900/10 text-blue-700 dark:text-blue-300 font-semibold rounded-lg hover:bg-blue-100/50 dark:hover:bg-blue-900/20 transition h-10 backdrop-blur-sm">Set</button>
                                </div>

                                @error('quantity') <span class="text-red-500 text-xs italic block mt-2">{{ $message }}</span> @enderror
                            </div>

                            <!-- Reason -->
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Reason (Optional)
                                </h3>
                                <x-inventory.form.form-textarea
                                    id="reason"
                                    name="reason"
                                    wire:model="reason"
                                    placeholder="e.g., Damaged goods, inventory count discrepancy, shrinkage..."
                                    rows="2"
                                />
                                @error('reason') <span class="text-red-500 text-xs italic block mt-2">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Product Selected</p>
                            <p class="text-gray-600 dark:text-gray-400">Search and select a product above to begin adjustment</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Summary & Actions -->
                @if(!empty($selectedProductData))
                    <div class="space-y-6">
                        <!-- Summary Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Summary
                            </h3>

                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Current Stock</span>
                                    <span class="font-bold text-lg text-gray-900 dark:text-white">{{ $selectedProductData['current_stock'] }}</span>
                                </div>
                                @if($quantity)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Adjustment</span>
                                        <span class="font-bold text-lg {{ $quantity > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">{{ $quantity > 0 ? '+' : '' }}{{ $quantity }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 dark:border-gray-600 pt-3 flex justify-between items-center p-3 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg">
                                        <span class="font-semibold text-gray-900 dark:text-white">New Stock</span>
                                        <span class="font-black text-xl text-blue-600 dark:text-blue-400">{{ max(0, (int)($selectedProductData['current_stock'] + $quantity)) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            @if(!empty($selectedProductData) && $quantity)
                                <button type="submit" class="w-full py-3 px-6 border-2 border-blue-300/50 dark:border-blue-800/50 bg-blue-600/30 dark:bg-blue-600/20 hover:bg-blue-500/40 dark:hover:bg-blue-500/30 text-blue-900 dark:text-white font-bold rounded-lg transition text-base backdrop-blur-sm">
                                    Confirm
                                </button>
                            @endif
                            <button type="button" wire:click="clearProductSelection" class="w-full py-3 px-6 border-2 border-violet-200/50 dark:border-violet-800/50 bg-white/50 dark:bg-gray-800/50 text-violet-900 dark:text-white font-bold rounded-lg hover:bg-white/70 dark:hover:bg-gray-700/70 transition text-base backdrop-blur-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
