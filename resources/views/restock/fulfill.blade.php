@extends('layouts.app')

@section('content')
<?php view()->share('header', 'Fulfill Restock Plan #' . $restock->id); ?>

<div class="min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Items -->
                <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-lg border border-white/20 dark:border-gray-700/20 shadow-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Items to Fulfill</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="text-left py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Product</th>
                                    <th class="text-center py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Current Stock</th>
                                    <th class="text-center py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">To Add</th>
                                    <th class="text-center py-2 px-2 text-sm font-semibold text-gray-700 dark:text-gray-300">New Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="py-3 px-2 text-gray-900 dark:text-white">{{ $item->product->name }}</td>
                                        <td class="py-3 px-2 text-center text-gray-900 dark:text-white">{{ $item->product->current_stock }}</td>
                                        <td class="py-3 px-2 text-center font-medium text-blue-600 dark:text-blue-400">+{{ $item->quantity_requested }}</td>
                                        <td class="py-3 px-2 text-center font-bold text-gray-900 dark:text-white">
                                            {{ $item->product->current_stock + $item->quantity_requested }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Warning -->
                <div class="bg-amber-50/30 dark:bg-amber-950/20 border-2 border-amber-200/50 dark:border-amber-800/50 rounded-lg p-6 backdrop-blur-sm">
                    <h3 class="font-semibold text-amber-900 dark:text-amber-300 mb-2">⚠️ Please Confirm</h3>
                    <p class="text-amber-800 dark:text-amber-200 text-sm">
                        Once you confirm, all {{ $summary['items_count'] }} products will be marked as "In Stock" and stock levels will be updated immediately.
                        This action cannot be undone. Make sure all items have been received and verified.
                    </p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Summary -->
                <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-lg border border-white/20 dark:border-gray-700/20 shadow-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Summary</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Items:</span>
                            <span class="font-medium">{{ $summary['items_count'] }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Total Cost:</span>
                            <span class="font-medium">{{ $summary['total_cost'] }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Budget:</span>
                            <span class="font-medium">{{ $summary['budget'] }}</span>
                        </div>
                    </div>

                    <!-- Budget Status -->
                    @php
                        $budgetStatus = $summary['budget_status'];
                    @endphp
                    <div class="p-4 rounded-lg @if($budgetStatus === 'over') bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 @elseif($budgetStatus === 'under') bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 @elseif($budgetStatus === 'fit') bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 @endif">
                        <div class="flex justify-between items-center @if($budgetStatus === 'over') text-green-900 dark:text-green-300 @elseif($budgetStatus === 'under') text-red-900 dark:text-red-300 @elseif($budgetStatus === 'fit') text-emerald-900 dark:text-emerald-300 @endif">
                            <span class="font-semibold">
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
                                    ₱{{ $summary['difference'] }}
                                @elseif($budgetStatus === 'under')
                                    ₱{{ $summary['difference'] }}
                                @elseif($budgetStatus === 'fit')
                                    ₱0.00
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <form action="{{ route('restock.confirmFulfill', $restock) }}" method="POST" class="space-y-2">
                    @csrf
                    <button type="submit" class="w-full bg-green-50/30 dark:bg-green-950/20 text-green-700 dark:text-green-300 border-2 border-green-200/50 dark:border-green-800/50 hover:bg-green-100/40 dark:hover:bg-green-900/30 font-medium py-3 rounded-lg transition backdrop-blur-sm">
                        ✓ Confirm & Fulfill
                    </button>
                    <a href="{{ route('restock.show', $restock) }}" class="block text-center bg-gray-200/30 dark:bg-gray-800/20 text-gray-700 dark:text-gray-300 border-2 border-gray-300/50 dark:border-gray-700/50 hover:bg-gray-300/40 dark:hover:bg-gray-700/30 font-medium py-3 rounded-lg transition backdrop-blur-sm">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
