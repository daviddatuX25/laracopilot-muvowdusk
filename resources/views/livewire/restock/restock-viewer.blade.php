<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Items ({{ count($items) }})</h2>

                    @if($items->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="text-left py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Product</th>
                                        <th class="text-center py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Qty</th>
                                        <th class="text-right py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Unit Cost</th>
                                        <th class="text-right py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td class="py-3 px-2 text-gray-900 dark:text-white">
                                                <div class="font-medium">{{ $item->product->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->product->sku }}</div>
                                            </td>
                                            <td class="py-3 px-2 text-center text-gray-900 dark:text-white">{{ $item->quantity_requested }}</td>
                                            <td class="py-3 px-2 text-right text-gray-900 dark:text-white">₱{{ number_format($item->unit_cost, 2) }}</td>
                                            <td class="py-3 px-2 text-right font-medium text-gray-900 dark:text-white">₱{{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <p>No items in this plan yet.</p>
                        </div>
                    @endif
                </div>

                <!-- Notes -->
                @if($restock->notes)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Notes</h2>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $restock->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Summary</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Cart Total:</span>
                            <span class="font-medium">₱{{ number_format($cartTotal, 2) }}</span>
                        </div>

                        @if($taxAmount > 0)
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Tax ({{ $restock->tax_percentage }}%):</span>
                                <span class="font-medium">₱{{ number_format($taxAmount, 2) }}</span>
                            </div>
                        @endif

                        @if((float) $restock->shipping_fee > 0)
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Shipping:</span>
                                <span class="font-medium">₱{{ number_format((float) $restock->shipping_fee, 2) }}</span>
                            </div>
                        @endif

                        @if((float) $restock->labor_fee > 0)
                            <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                <span>Labor:</span>
                                <span class="font-medium">₱{{ number_format((float) $restock->labor_fee, 2) }}</span>
                            </div>
                        @endif
                        @if($restock->other_fees && is_array($restock->other_fees) && !empty($restock->other_fees))
                            @foreach($restock->other_fees as $fee)
                                @if(!empty($fee['label']) && (float) ($fee['amount'] ?? 0) > 0)
                                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                        <span>{{ $fee['label'] }}:</span>
                                        <span class="font-medium">₱{{ number_format((float) $fee['amount'], 2) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
                            <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                                <span>Total Cost:</span>
                                <span>₱{{ number_format($totalCost, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Budget Status -->
                @if(count($items) > 0 && (float) $restock->budget_amount > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Budget</h2>

                    <div class="mb-6 p-4 rounded-lg @if($budgetStatus === 'over') bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 @elseif($budgetStatus === 'under') bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 @elseif($budgetStatus === 'fit') bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 @endif">
                        <div class="font-semibold mb-2 @if($budgetStatus === 'over') text-green-900 dark:text-green-300 @elseif($budgetStatus === 'under') text-red-900 dark:text-red-300 @elseif($budgetStatus === 'fit') text-emerald-900 dark:text-emerald-300 @endif">
                            Budget: ₱{{ number_format((float) $restock->budget_amount, 2) }}
                        </div>
                        <div class="flex justify-between items-center @if($budgetStatus === 'over') text-green-900 dark:text-green-300 @elseif($budgetStatus === 'under') text-red-900 dark:text-red-300 @elseif($budgetStatus === 'fit') text-emerald-900 dark:text-emerald-300 @endif">
                            <span>
                                @if($budgetStatus === 'over')
                                    ✓ Surplus
                                @elseif($budgetStatus === 'under')
                                    ⚠️ Shortage
                                @elseif($budgetStatus === 'fit')
                                    ✓ Perfect Match
                                @endif
                            </span>
                            <span class="font-bold text-lg">
                                @if($budgetStatus === 'over')
                                    ₱{{ number_format(abs($budgetDifference), 2) }}
                                @elseif($budgetStatus === 'under')
                                    ₱{{ number_format(abs($budgetDifference), 2) }}
                                @elseif($budgetStatus === 'fit')
                                    ₱0.00
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Actions -->
                <div class="space-y-2">
                    @if(!$restock->isFulfilled())
                        <a href="{{ route('restock.fulfill', $restock) }}" class="block text-center bg-green-50/30 dark:bg-green-950/20 text-green-700 dark:text-green-300 border-2 border-green-200/50 dark:border-green-800/50 hover:bg-green-100/40 dark:hover:bg-green-900/30 font-medium py-3 rounded-lg transition backdrop-blur-sm">
                            Fulfill Plan
                        </a>
                        <a href="{{ route('restock.edit', $restock) }}" class="block text-center bg-amber-50/30 dark:bg-amber-950/20 text-amber-700 dark:text-amber-300 border-2 border-amber-200/50 dark:border-amber-800/50 hover:bg-amber-100/40 dark:hover:bg-amber-900/30 font-medium py-3 rounded-lg transition backdrop-blur-sm">
                            Edit Plan
                        </a>
                        <a href="{{ route('restock.print-plan', $restock) }}" class="block text-center bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 border-2 border-blue-200/50 dark:border-blue-800/50 hover:bg-blue-100/40 dark:hover:bg-blue-900/30 font-medium py-3 rounded-lg transition backdrop-blur-sm">
                            Print Plan
                        </a>
                    @endif
                    @if($restock->isFulfilled())
                        <a href="{{ route('restock.print-receipt', $restock) }}" class="block text-center bg-green-50/30 dark:bg-green-950/20 text-green-700 dark:text-green-300 border-2 border-green-200/50 dark:border-green-800/50 hover:bg-green-100/40 dark:hover:bg-green-900/30 font-medium py-3 rounded-lg transition backdrop-blur-sm">
                            Print Receipt
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
