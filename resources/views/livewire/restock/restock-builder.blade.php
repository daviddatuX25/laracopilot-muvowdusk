<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Panel: Builder -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Budget Input -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Budget</h2>
                    <div class="flex items-end gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Budget Amount
                            </label>
                            <input
                                type="number"
                                wire:model.defer="budgetAmount"
                                @blur="$event.target.value = ($event.target.value === '' ? '0' : $event.target.value); $wire.budgetAmount = parseFloat($event.target.value || 0); $wire.call('validateBudgetAmount')"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <div class="text-2xl font-bold text-blue-600">
                            ₱{{ number_format($budgetAmount, 2) }}
                        </div>
                    </div>
                </div>

                <!-- Product Search & Selection -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Add Products</h2>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Search Products (Name, SKU, Barcode)
                        </label>
                        <div class="relative">
                            <input
                                type="text"
                                wire:model.live.debounce-300ms="searchQuery"
                                placeholder="Type to search..."
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            />

                            @if(!empty($searchResults))
                                <div class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-10 max-h-64 overflow-y-auto">
                                    @foreach($searchResults as $product)
                                        <button
                                            type="button"
                                            wire:click="selectProduct({{ $product['id'] }})"
                                            class="w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 border-b border-gray-200 dark:border-gray-600 last:border-b-0"
                                        >
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $product['name'] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                SKU: {{ $product['sku'] }} | Stock: {{ $product['current_stock'] }}
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($selectedProduct)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $selectedProduct->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">SKU: {{ $selectedProduct->sku }}</p>
                                </div>
                                <button
                                    type="button"
                                    wire:click="clearSelection"
                                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-bold text-lg"
                                >
                                    ✕
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <!-- Quantity -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Quantity
                                    </label>

                                    <div class="flex items-center gap-2 w-full">
                                        <button
                                            type="button"
                                            wire:click="decrementQuantity"
                                            class="px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded hover:bg-gray-300 dark:hover:bg-gray-500 transition"
                                        >
                                            −
                                        </button>

                                        <input
                                            type="number"
                                            wire:model.live="selectedQuantity"
                                            min="1"
                                            class="flex-1 px-3 py-1 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white text-center w-full"
                                        />

                                        <button
                                            type="button"
                                            wire:click="incrementQuantity"
                                            class="px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded hover:bg-gray-300 dark:hover:bg-gray-500 transition"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Unit Cost -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Unit Cost
                                    </label>

                                    <input
                                        type="number"
                                        wire:model.live="selectedUnitCost"
                                        step="0.01"
                                        min="0"
                                        class="w-full px-3 py-1 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white"
                                    />
                                </div>

                            </div>

                            <button
                                type="button"
                                wire:click="addToCart"
                                class="w-full bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 border-2 border-blue-200/50 dark:border-blue-800/50 hover:bg-blue-100/40 dark:hover:bg-blue-900/30 font-medium py-2 rounded-lg transition backdrop-blur-sm"
                            >
                                Add to Cart
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Cart Items -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Shopping Cart</h2>
                        @if(!empty($cartItems))
                            <button
                                type="button"
                                wire:click="clearCart"
                                class="text-sm text-red-600 hover:text-red-700 font-medium"
                            >
                                Clear Cart
                            </button>
                        @endif
                    </div>

                    @if(empty($cartItems))
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            Cart is empty. Add products to get started.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Product</th>
                                        <th class="text-center py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Qty</th>
                                        <th class="text-right py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Unit Cost</th>
                                        <th class="text-right py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Subtotal</th>
                                        <th class="text-center py-2 px-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $index => $item)
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <td class="py-3 px-2 text-gray-900 dark:text-white">{{ $item['product_name'] }}</td>
                                            <td class="py-3 px-2">
                                                <input
                                                    type="number"
                                                    wire:change="updateQuantity({{ $index }}, $event.target.value)"
                                                    wire:model="cartItems.{{ $index }}.quantity"
                                                    min="1"
                                                    class="w-16 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-center dark:bg-gray-700 dark:text-white"
                                                />
                                            </td>
                                            <td class="py-3 px-2 text-right">
                                                <input
                                                    type="number"
                                                    wire:change="updateUnitCost({{ $index }}, $event.target.value)"
                                                    wire:model="cartItems.{{ $index }}.unit_cost"
                                                    step="0.01"
                                                    min="0"
                                                    class="w-24 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-right dark:bg-gray-700 dark:text-white"
                                                />
                                            </td>
                                            <td class="py-3 px-2 text-right font-medium text-gray-900 dark:text-white">
                                                ₱{{ number_format($item['subtotal'], 2) }}
                                            </td>
                                            <td class="py-3 px-2 text-center">
                                                <button
                                                    type="button"
                                                    wire:click="removeFromCart({{ $index }})"
                                                    class="text-red-600 hover:text-red-700 font-medium text-sm"
                                                >
                                                    Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Costs Configuration -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Additional Costs</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tax Percentage (%)
                            </label>
                            <input
                                type="number"
                                wire:model="taxPercentage"
                                @blur="$event.target.value = ($event.target.value === '' ? '0' : $event.target.value); $wire.taxPercentage = parseFloat($event.target.value || 0)"
                                @change="$wire.call('validateTaxPercentage')"
                                step="0.01"
                                min="0"
                                max="100"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Shipping Fee
                            </label>
                            <input
                                type="number"
                                wire:model="shippingFee"
                                @blur="$event.target.value = ($event.target.value === '' ? '0' : $event.target.value); $wire.shippingFee = parseFloat($event.target.value || 0)"
                                @change="$wire.call('validateShippingFee')"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Labor Fee
                            </label>
                            <input
                                type="number"
                                wire:model="laborFee"
                                @blur="$event.target.value = ($event.target.value === '' ? '0' : $event.target.value); $wire.laborFee = parseFloat($event.target.value || 0)"
                                @change="$wire.call('validateLaborFee')"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                    </div>

                    <!-- Save Default Costs Button -->
                    <div class="mb-4">
                        <button
                            wire:click="saveDefaultCosts"
                            type="button"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                        >
                            <span class="text-sm font-medium">💾 Save as Default Costs</span>
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            This will save these values as your default costs for future plans
                        </p>
                    </div>

                    <!-- Other Fees -->
                    <div class="space-y-2 mb-4">
                        @foreach($otherFees as $index => $fee)
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    wire:model="otherFees.{{ $index }}.label"
                                    wire:change="calculateTotals"
                                    placeholder="Fee label"
                                    class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white"
                                />
                                <input
                                    type="number"
                                    wire:model="otherFees.{{ $index }}.amount"
                                    wire:change="calculateTotals"
                                    placeholder="Amount"
                                    step="0.01"
                                    min="0"
                                    class="w-32 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white"
                                />
                                <button
                                    type="button"
                                    wire:click="removeOtherFee({{ $index }})"
                                    class="px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
                                >
                                    ✕
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button
                        type="button"
                        wire:click="addOtherFee"
                        class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                    >
                        + Add Other Fee
                    </button>
                </div>

                <!-- Notes -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notes
                    </label>
                    <textarea
                        wire:model="notes"
                        rows="4"
                        placeholder="Add any notes about this restock plan..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    ></textarea>
                </div>
            </div>

            <!-- Right Panel: Summary -->
            <div class="lg:col-span-1">
                <!-- Summary Box -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 sticky top-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Summary</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Cart Total:</span>
                            <span class="font-medium">₱{{ number_format($cartTotal, 2) }}</span>
                        </div>

                        @if(($taxPercentage ?? 0) > 0)
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Tax ({{ $taxPercentage }}%):</span>
                                <span class="font-medium">₱{{ number_format($taxAmount, 2) }}</span>
                            </div>
                        @endif

                        @if($shippingFee > 0)
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Shipping:</span>
                                <span class="font-medium">₱{{ number_format($shippingFee, 2) }}</span>
                            </div>
                        @endif

                        @if($laborFee > 0)
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Labor:</span>
                                <span class="font-medium">₱{{ number_format($laborFee, 2) }}</span>
                            </div>
                        @endif

                        @foreach($otherFees as $fee)
                            @if(!empty($fee['label']) && $fee['amount'] > 0)
                                <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                    <span>{{ $fee['label'] }}:</span>
                                    <span class="font-medium">₱{{ number_format($fee['amount'], 2) }}</span>
                                </div>
                            @endif
                        @endforeach

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                            <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                                <span>Total Cost:</span>
                                <span>₱{{ number_format($totalCost, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Budget Status - Only show if cart has items and budget > 0 -->
                    @if(count($cartItems) > 0 && $budgetAmount > 0)
                    <div class="mb-6 p-4 rounded-lg @if($budgetStatus === 'over') bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 @elseif($budgetStatus === 'under') bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 @elseif($budgetStatus === 'fit') bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 @endif">
                        <div class="font-semibold mb-2 @if($budgetStatus === 'over') text-green-900 dark:text-green-300 @elseif($budgetStatus === 'under') text-red-900 dark:text-red-300 @elseif($budgetStatus === 'fit') text-emerald-900 dark:text-emerald-300 @endif">
                            Budget: ₱{{ number_format($budgetAmount, 2) }}
                        </div>
                        <div class="flex justify-between items-center @if($budgetStatus === 'over') text-green-900 dark:text-green-300 @elseif($budgetStatus === 'under') text-red-900 dark:text-red-300 @elseif($budgetStatus === 'fit') text-emerald-900 dark:text-emerald-300 @endif">
                            <span>
                                @if($budgetStatus === 'over')
                                    ✓ Surplus
                                @elseif($budgetStatus === 'under')
                                    ⚠️ Insuffecient Budget
                                @elseif($budgetStatus === 'fit')
                                    ✓ Perfect Match
                                @endif
                            </span>
                            <span class="font-bold text-lg">
                                @if($budgetStatus === 'over')
                                    +₱{{ number_format($budgetDifference, 2) }}
                                @elseif($budgetStatus === 'under')
                                    -₱{{ number_format($budgetDifference, 2) }}
                                @elseif($budgetStatus === 'fit')
                                    ₱0.00
                                @endif
                            </span>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <button
                            type="button"
                            wire:click="saveRestockPlan"
                            @if(empty($cartItems) || $budgetAmount <= 0) disabled @endif
                            class="w-full bg-green-50/30 dark:bg-green-950/20 text-green-700 dark:text-green-300 border-2 border-green-200/50 dark:border-green-800/50 hover:bg-green-100/40 dark:hover:bg-green-900/30 disabled:opacity-50 disabled:cursor-not-allowed font-medium py-3 rounded-lg transition backdrop-blur-sm"
                        >
                            Save Restock Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
