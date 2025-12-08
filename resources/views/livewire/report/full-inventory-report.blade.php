<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-violet-100 leading-tight">
            {{ __('Full Inventory Report') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card class="mb-8 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 border-0">
                <div class="flex flex-col justify-between items-center mb-4 lg:flex-row md:items-start gap-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Inventory Summary</h3>
                    <div class="flex gap-2 no-print">
                        <x-inventory.button.button variant="danger" size="sm" wire:click="exportPdf">
                            📄 Export PDF
                        </x-inventory.button.button>
                        <x-inventory.button.button variant="success" size="sm" wire:click="exportCsv">
                            📥 Export CSV
                        </x-inventory.button.button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                    <x-inventory.card.stat-card
                        title="Total Products"
                        value="{{ $totalProducts }}"
                        variant="blue"
                    />
                    <x-inventory.card.stat-card
                        title="Total Stock Units"
                        value="{{ $totalStock }}"
                        variant="green"
                    />
                    <x-inventory.card.stat-card
                        title="Inventory Value (Cost)"
                        value="₱{{ number_format($totalValue, 2) }}"
                        variant="purple"
                    />
                </div>

                <!-- Stock Status Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-100 dark:bg-green-900 rounded-lg p-4 border-l-4 border-green-500">
                        <p class="text-green-700 dark:text-green-200 text-sm font-semibold">✓ Normal Stock</p>
                        <p class="text-2xl font-bold text-green-700 dark:text-green-200">{{ $stockStatus['normal'] }}</p>
                    </div>
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-lg p-4 border-l-4 border-yellow-500">
                        <p class="text-yellow-700 dark:text-yellow-200 text-sm font-semibold">⚠️ Low Stock</p>
                        <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-200">{{ $stockStatus['low'] }}</p>
                    </div>
                    <div class="bg-red-100 dark:bg-red-900 rounded-lg p-4 border-l-4 border-red-500">
                        <p class="text-red-700 dark:text-red-200 text-sm font-semibold">❌ Out of Stock</p>
                        <p class="text-2xl font-bold text-red-700 dark:text-red-200">{{ $stockStatus['out'] }}</p>
                    </div>
                </div>
            </x-inventory.card.card>

            <!-- Filters Section -->
            <x-inventory.card.card class="mb-6 no-print">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-4">
                    <div class="md:col-span-3 xl:col-span-2">
                        <x-inventory.form.form-input-with-icon
                            name="search"
                            wire:model.live="search"
                            label="Search"
                            placeholder="Name, SKU, or Barcode..."
                            icon="search"
                        />
                    </div>

                    <div class="md:col-span-1">
                        <x-inventory.form.form-select
                            name="filterCategory"
                            wire:model.live="filterCategory"
                            label="Category"
                        >
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-inventory.form.form-select>
                    </div>

                    <div class="md:col-span-1">
                        <x-inventory.form.form-select
                            name="filterSupplier"
                            wire:model.live="filterSupplier"
                            label="Supplier"
                        >
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </x-inventory.form.form-select>
                    </div>

                    <div class="md:col-span-1">
                        <x-inventory.form.form-select
                            name="filterStockStatus"
                            wire:model.live="filterStockStatus"
                            label="Stock Status"
                        >
                            <option value="">All Items</option>
                            <option value="normal">✓ Normal Stock</option>
                            <option value="low">⚠️ Low Stock</option>
                            <option value="out">❌ Out of Stock</option>
                        </x-inventory.form.form-select>
                    </div>
                </div>
            </x-inventory.card.card>

            <!-- Category Breakdown -->
            <x-inventory.card.card class="mb-6 no-print">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Inventory by Category</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categoryStats as $cat)
                        <x-inventory.card.card class="border-l-4 border-indigo-500">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $cat->name }}</h4>
                            <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Products</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $cat->products_count }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Total Stock</p>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">{{ $cat->products_sum_current_stock ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-400 text-xs">Value</p>
                                <p class="font-bold text-purple-600 dark:text-purple-400">₱{{ number_format($cat->products_sum_total_cost ?? 0, 2) }}</p>
                            </div>
                        </x-inventory.card.card>
                    @endforeach
                </div>
            </x-inventory.card.card>

            <!-- Supplier Breakdown -->
            <x-inventory.card.card class="mb-6 no-print">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Inventory by Supplier</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($supplierStats as $sup)
                        <x-inventory.card.card class="border-l-4 border-purple-500">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $sup->name }}</h4>
                            <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Products</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $sup->products_count }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Total Stock</p>
                                    <p class="text-lg font-bold text-green-600 dark:text-green-400">{{ $sup->products_sum_current_stock ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-400 text-xs">Value</p>
                                <p class="font-bold text-purple-600 dark:text-purple-400">₱{{ number_format($sup->products_sum_total_cost ?? 0, 2) }}</p>
                            </div>
                        </x-inventory.card.card>
                    @endforeach
                </div>
            </x-inventory.card.card>

            <!-- Inventory Table -->
            <x-inventory.card.card>
                <div class="overflow-x-auto">
                    <x-inventory.table.table>
                        <x-inventory.table.table-header :columns="['Product Name', 'SKU', 'Barcode', 'Category', 'Supplier', 'Cost Price', 'Sell Price', 'Stock', 'Reorder Lvl', 'Total Value', 'Status']" />

                        @forelse($products as $product)
                            @php
                                $totalValue = $product->current_stock * $product->cost_price;
                                $statusClass = $product->current_stock <= 0
                                    ? 'danger'
                                    : ($product->current_stock <= $product->reorder_level
                                        ? 'warning'
                                        : 'success');
                                $statusText = $product->current_stock <= 0
                                    ? 'Out'
                                    : ($product->current_stock <= $product->reorder_level
                                        ? 'Low'
                                        : 'OK');
                            @endphp
                            <x-inventory.table.table-row class="cursor-pointer" wire:click="showProductModal({{ $product->id }})">
                                <x-inventory.table.table-cell class="font-medium text-indigo-600 dark:text-indigo-400 hover:underline">{{ $product->name }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-gray-600 dark:text-gray-400 font-mono">{{ $product->sku }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-center text-gray-600 dark:text-gray-400 font-mono text-xs">{{ $product->barcode ?? '-' }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-gray-600 dark:text-gray-400">{{ $product->category?->name ?? 'N/A' }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-gray-600 dark:text-gray-400">{{ $product->supplier?->name ?? 'N/A' }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-right text-gray-900 dark:text-gray-100">₱{{ number_format($product->cost_price, 2) }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-right text-gray-900 dark:text-gray-100">₱{{ number_format($product->selling_price, 2) }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-center font-bold text-gray-900 dark:text-gray-100">{{ $product->current_stock }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-center text-gray-600 dark:text-gray-400">{{ $product->reorder_level }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-right font-semibold text-gray-900 dark:text-gray-100">₱{{ number_format($totalValue, 2) }}</x-inventory.table.table-cell>
                                <x-inventory.table.table-cell class="text-center">
                                    <x-inventory.badge.badge variant="{{ $statusClass }}">{{ $statusText }}</x-inventory.badge.badge>
                                </x-inventory.table.table-cell>
                            </x-inventory.table.table-row>
                        @empty
                            <tr>
                                <td colspan="11" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                    No products found
                                </td>
                            </tr>
                        @endforelse
                    </x-inventory.table.table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 no-print">
                    {{ $products->links() }}
                </div>

                <!-- Print Footer -->
                <div class="p-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-400 only-print">
                    <p>Generated on: {{ now()->format('M d, Y H:i A') }}</p>
                    <p>Total Products: {{ $totalProducts }} | Total Stock: {{ $totalStock }} units | Total Value: ₱{{ number_format($totalValue, 2) }}</p>
                </div>
            </x-inventory.card.card>
        </div>
    </div>

    <!-- Product Details Modal (Keep original modal as-is, just add dark mode classes) -->
    @if($showModal && !empty($modalProductData))
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $modalProductData['name'] }}</h2>
                    <button wire:click="closeModal" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 text-2xl leading-none">×</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Product Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">SKU</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $modalProductData['sku'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Barcode</p>
                            <p class="text-lg font-mono text-gray-900 dark:text-white">{{ $modalProductData['barcode'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Category</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $modalProductData['category_name'] ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Supplier</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $modalProductData['supplier_name'] ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Stock & Pricing Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="bg-blue-50 dark:bg-blue-900 rounded p-3">
                            <p class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Current Stock</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $modalProductData['current_stock'] }}</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900 rounded p-3">
                            <p class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Reorder Level</p>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">{{ $modalProductData['reorder_level'] }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 rounded p-3">
                            <p class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Cost Price</p>
                            <p class="text-lg font-bold text-green-600 dark:text-green-300">₱{{ number_format($modalProductData['cost_price'], 2) }}</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900 rounded p-3">
                            <p class="text-gray-600 dark:text-gray-300 text-sm font-semibold">Selling Price</p>
                            <p class="text-lg font-bold text-purple-600 dark:text-purple-300">₱{{ number_format($modalProductData['selling_price'], 2) }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($modalProductData['description'])
                        <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold mb-2">Description</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $modalProductData['description'] }}</p>
                        </div>
                    @endif

                    <!-- Recent Stock Movements -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recent Stock Movements</h3>
                        @if($modalMovements->count() > 0)
                            <div class="space-y-2">
                                @foreach($modalMovements as $movement)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded border border-gray-200 dark:border-gray-600">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                @if($movement->type === 'in')
                                                    📥 Stock In
                                                @elseif($movement->type === 'out')
                                                    📤 Stock Out
                                                @else
                                                    ⚙️ Adjustment
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ $movement->created_at->format('M d, Y H:i A') }}</p>
                                        </div>
                                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No recent movements</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Print styles --}}
    @once
    <style media="print">
        .no-print,
        .no-print * {
            display: none !important;
        }

        .only-print {
            display: block !important;
        }

        body {
            margin: 0;
            padding: 0;
            background: white;
        }

        table {
            width: 100%;
            margin: 0;
        padding: 0;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 11px;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    h2 {
        font-size: 18px;
        margin: 0 0 10px 0;
        page-break-inside: avoid;
    }

    .bg-gradient-to-r {
        background: linear-gradient(to right, #eff6ff, #e0e7ff) !important;
    }

    .shadow-xl {
        box-shadow: none !important;
    }

    @page {
        margin: 0.5in;
        size: A4;
    }
    </style>
    @endonce
</div>
