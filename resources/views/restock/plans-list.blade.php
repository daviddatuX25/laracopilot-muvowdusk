@extends('layouts.app')

@section('content')
<div x-data="{
    viewMode: 'table',
    statusFilter: '{{ request('status') ?? '' }}',
    init() {
        const stored = localStorage.getItem('restockPlansViewMode');
        if (stored) {
            this.viewMode = stored;
        }
    },
    toggleViewMode() {
        this.viewMode = this.viewMode === 'table' ? 'card' : 'table';
        localStorage.setItem('restockPlansViewMode', this.viewMode);
    }
}" x-cloak @init="init">
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <x-inventory.card.card>
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Restock Plans</h1>
                    <div class="flex gap-3">
                        <button @click="toggleViewMode" class="px-4 py-2 border-2 border-blue-500 text-blue-600 dark:text-blue-400 font-semibold rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition text-sm flex items-center gap-2">
                            <svg x-show="viewMode === 'table'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2h-6a2 2 0 01-2-2V4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6m-6 4h6"/>
                            </svg>
                            <svg x-show="viewMode === 'card'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16"/>
                            </svg>
                            <span x-text="viewMode === 'table' ? 'Card View' : 'Table View'"></span>
                        </button>
                        <a href="{{ route('restock.builder') }}">
                            <button class="px-4 py-2 bg-blue-600 dark:bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-700 transition text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                New Plan
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <form method="GET" class="mb-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Status</label>
                            <select name="status" x-model="statusFilter" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Statuses</option>
                                <option value="draft">Draft</option>
                                <option value="pending">Pending</option>
                                <option value="fulfilled">Fulfilled</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort by Date</label>
                            <select name="sort_order" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="desc" @if(request('sort_order', 'desc') === 'desc') selected @endif>Newest First</option>
                                <option value="asc" @if(request('sort_order') === 'asc') selected @endif>Oldest First</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-end">
                        <button type="submit" class="px-6 py-2 border-2 border-blue-600 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-700 transition">
                            Apply Filters
                        </button>
                        @if(request('status') || request('date_from') || request('date_to'))
                            <a href="{{ route('restock.plans') }}" class="px-6 py-2 border-2 border-gray-400 text-gray-600 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>

                @if ($restocks->isEmpty())
                    <x-inventory.state.empty-state title="No Restock Plans" message="Create your first restock plan to get started!" />
                @else
                    <!-- Table View -->
                    <div x-show="viewMode === 'table'" x-cloak>
                        <div class="overflow-x-auto">
                            <x-inventory.table.table>
                                <x-inventory.table.table-header :columns="['Plan', 'Items', 'Cart Total', 'Total Cost', 'Budget', 'Status', 'Created', 'Actions']" />
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($restocks as $restock)
                                        <x-inventory.table.table-row>
                                            <x-inventory.table.table-cell>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">#{{ $restock->id }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $restock->created_at->format('M d, Y') }}</div>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $restock->items()->count() }}</span>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                @php
                                                    $items = $restock->items()->with('product')->get();
                                                    $cartTotal = $items->sum(fn($item) => (float)$item->subtotal);
                                                @endphp
                                                <span class="text-sm text-gray-900 dark:text-white">₱{{ number_format($cartTotal, 2) }}</span>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                @php
                                                    $items = $restock->items()->with('product')->get();
                                                    $cartItems = $items->map(function ($item) {
                                                        return [
                                                            'product_id' => $item->product_id,
                                                            'product_name' => $item->product->name,
                                                            'quantity' => (int) $item->quantity_requested,
                                                            'unit_cost' => (float) $item->unit_cost,
                                                            'subtotal' => (float) $item->subtotal,
                                                        ];
                                                    })->toArray();

                                                    $costData = [
                                                        'budget_amount' => (float) $restock->budget_amount,
                                                        'tax_percentage' => (float) $restock->tax_percentage,
                                                        'shipping_fee' => (float) $restock->shipping_fee,
                                                        'labor_fee' => (float) $restock->labor_fee,
                                                        'other_fees' => array_map(function ($fee) {
                                                            return [
                                                                'amount' => (float) ($fee['amount'] ?? 0),
                                                                'label' => (string) ($fee['label'] ?? ''),
                                                            ];
                                                        }, $restock->other_fees ?? []),
                                                    ];

                                                    $calculations = app('App\Services\RestockService')->calculateTotalCost($cartItems, $costData);
                                                    $totalCost = $calculations['total_cost'];
                                                @endphp
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">₱{{ number_format($totalCost, 2) }}</span>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                {{-- the budget --}}
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">₱{{ number_format($restock->budget_amount, 2) }}</span>
                                                <span class="px-3 py-1 rounded-full text-xs font-medium @if($restock->budget_status === 'over') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 @elseif($restock->budget_status === 'fit') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                                                    @if($restock->budget_status === 'over')
                                                        Excess
                                                    @elseif($restock->budget_status === 'fit')
                                                        Perfect Match
                                                    @else
                                                        Insufficient
                                                    @endif
                                                </span>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <span class="px-3 py-1 rounded-full text-sm font-medium @if($restock->isFulfilled()) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 @elseif($restock->isDraft()) bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 @endif">
                                                    {{ strtoupper($restock->status) }}
                                                </span>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $restock->created_at->format('M d, Y H:i') }}</span>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-actions>
                                                <a href="{{ route('restock.show', $restock) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">View</a>
                                                @if(!$restock->isFulfilled())
                                                    <a href="{{ route('restock.edit', $restock) }}" class="text-amber-600 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 text-sm font-medium">Edit</a>
                                                    <a href="{{ route('restock.fulfill', $restock) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-medium">Fulfill</a>
                                                    <form action="{{ route('restock.destroy', $restock) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm font-medium">Delete</button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('restock.print-receipt', $restock) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-medium">Receipt</a>
                                                @endif
                                            </x-inventory.table.table-actions>
                                        </x-inventory.table.table-row>
                                    @endforeach
                                </tbody>
                            </x-inventory.table.table>
                        </div>
                    </div>

                    <!-- Card View -->
                    <div x-show="viewMode === 'card'" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($restocks as $restock)
                                <x-inventory.card.card class="hover:shadow-lg transition flex flex-col">
                                    <div class="flex-1 space-y-4">
                                        <!-- Header -->
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Plan #{{ $restock->id }}</h3>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $restock->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium @if($restock->isFulfilled()) bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 @elseif($restock->isDraft()) bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 @endif whitespace-nowrap">
                                                {{ strtoupper($restock->status) }}
                                            </span>
                                        </div>

                                        <!-- Items and Costs Info -->
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                                <p class="text-xs text-gray-600 dark:text-gray-400">Items</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $restock->items()->count() }}</p>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                                <p class="text-xs text-gray-600 dark:text-gray-400">Cart Total</p>
                                                @php
                                                    $items = $restock->items()->with('product')->get();
                                                    $cartTotal = $items->sum(fn($item) => (float)$item->subtotal);
                                                @endphp
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">₱{{ number_format($cartTotal, 2) }}</p>
                                            </div>
                                        </div>
                                        {{-- budget amount --}}
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Budget</p>
                                            <p class="text-lg font-bold text-gray-900 dark:text-white">₱{{ number_format($restock->budget_amount, 2) }}
                                            {{-- flag if within budget or no --}}
                                            <span class="px-2 py-1 rounded-full text-xs font-medium @if($restock->budget_status === 'over') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 @elseif($restock->budget_status === 'fit') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif mt-2 inline-block">
                                                @if($restock->budget_status === 'over')
                                                    Excess
                                                @elseif($restock->budget_status === 'fit')
                                                    Perfect Match
                                                @else
                                                    Insufficient
                                                @endif
                                            </span>
                                            </p>
                                        </div>
                                        <!-- Total Cost -->
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg">
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Total Cost</p>
                                            @php
                                                $items = $restock->items()->with('product')->get();
                                                $cartItems = $items->map(function ($item) {
                                                    return [
                                                        'product_id' => $item->product_id,
                                                        'product_name' => $item->product->name,
                                                        'quantity' => (int) $item->quantity_requested,
                                                        'unit_cost' => (float) $item->unit_cost,
                                                        'subtotal' => (float) $item->subtotal,
                                                    ];
                                                })->toArray();

                                                $costData = [
                                                    'budget_amount' => (float) $restock->budget_amount,
                                                    'tax_percentage' => (float) $restock->tax_percentage,
                                                    'shipping_fee' => (float) $restock->shipping_fee,
                                                    'labor_fee' => (float) $restock->labor_fee,
                                                    'other_fees' => array_map(function ($fee) {
                                                        return [
                                                            'amount' => (float) ($fee['amount'] ?? 0),
                                                            'label' => (string) ($fee['label'] ?? ''),
                                                        ];
                                                    }, $restock->other_fees ?? []),
                                                ];

                                                $calculations = app('App\Services\RestockService')->calculateTotalCost($cartItems, $costData);
                                                $totalCost = $calculations['total_cost'];
                                            @endphp
                                            <p class="text-lg font-bold text-gray-900 dark:text-white">₱{{ number_format($totalCost, 2) }}</p>
                                        </div>


                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col gap-2 pt-4 border-t border-gray-200 dark:border-gray-700 mt-4">
                                        <a href="{{ route('restock.show', $restock) }}" class="block">
                                            <button class="w-full px-3 py-2 text-sm border-2 border-blue-500 text-blue-600 dark:text-blue-400 font-semibold rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition">
                                                View Details
                                            </button>
                                        </a>
                                        @if(!$restock->isFulfilled())
                                            <div class="flex gap-2">
                                                <a href="{{ route('restock.edit', $restock) }}" class="flex-1">
                                                    <button class="w-full px-3 py-2 text-xs border-2 border-amber-500 text-amber-600 dark:text-amber-400 font-semibold rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20 transition">
                                                        Edit
                                                    </button>
                                                </a>
                                                <a href="{{ route('restock.fulfill', $restock) }}" class="flex-1">
                                                    <button class="w-full px-3 py-2 text-xs border-2 border-green-500 text-green-600 dark:text-green-400 font-semibold rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition">
                                                        Fulfill
                                                    </button>
                                                </a>
                                            </div>
                                            <button @click="if(confirm('Delete this plan?')) { document.getElementById('delete-form-card-{{ $restock->id }}').submit() }" class="w-full px-3 py-2 text-sm border-2 border-red-500 text-red-600 dark:text-red-400 font-semibold rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                                Delete
                                            </button>
                                            <form id="delete-form-card-{{ $restock->id }}" action="{{ route('restock.destroy', $restock) }}" method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <a href="{{ route('restock.print-receipt', $restock) }}" class="block">
                                                <button class="w-full px-3 py-2 text-sm border-2 border-green-500 text-green-600 dark:text-green-400 font-semibold rounded-lg hover:bg-green-50 dark:hover:bg-green-900/20 transition">
                                                    Print Receipt
                                                </button>
                                            </a>
                                        @endif
                                    </div>
                                </x-inventory.card.card>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($restocks->hasPages())
                        <div class="mt-6">
                            {{ $restocks->links() }}
                        </div>
                    @endif
                @endif
            </x-inventory.card.card>
        </div>
    </div>
</div>
@endsection
