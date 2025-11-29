<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Full Inventory Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Summary Cards -->
                <div class="p-6 sm:px-20 md:px-10 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <div class="flex flex-col justify-between items-center mb-4 lg:flex-row md:items-start gap-4">
                        <h3 class="text-2xl font-bold text-gray-800">Inventory Summary</h3>
                        <div class="flex gap-2 no-print">
                            <button wire:click="exportPdf" class="px-6 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition">
                                📄 Export PDF
                            </button>
                            <button wire:click="exportCsv" class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                                📥 Export CSV
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                        <div class="bg-white rounded-lg p-4 shadow">
                            <p class="text-gray-600 text-sm font-semibold">Total Products</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow">
                            <p class="text-gray-600 text-sm font-semibold">Total Stock Units</p>
                            <p class="text-3xl font-bold text-green-600">{{ $totalStock }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow">
                            <p class="text-gray-600 text-sm font-semibold">Inventory Value (Cost)</p>
                            <p class="text-3xl font-bold text-purple-600">₱{{ number_format($totalValue, 2) }}</p>
                        </div>
                    </div>

                    <!-- Stock Status Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-100 rounded-lg p-4 border-l-4 border-green-500">
                            <p class="text-green-700 text-sm font-semibold">✓ Normal Stock</p>
                            <p class="text-2xl font-bold text-green-700">{{ $stockStatus['normal'] }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-4 border-l-4 border-yellow-500">
                            <p class="text-yellow-700 text-sm font-semibold">⚠️ Low Stock</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $stockStatus['low'] }}</p>
                        </div>
                        <div class="bg-red-100 rounded-lg p-4 border-l-4 border-red-500">
                            <p class="text-red-700 text-sm font-semibold">❌ Out of Stock</p>
                            <p class="text-2xl font-bold text-red-700">{{ $stockStatus['out'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Filters Section -->
                <div class="p-6 no-print">
                    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-3 xl:col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Search</label>
                            <input type="text"
                                   wire:model.live="search"
                                   placeholder="Name, SKU, or Barcode..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Category Filter -->
                        <div class="md:col-span-1">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                            <select wire:model.live="filterCategory" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Supplier Filter -->
                        <div class="md:col-span-1">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Supplier</label>
                            <select wire:model.live="filterSupplier" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Suppliers</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="md:col-span-1">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stock Status</label>
                            <select wire:model.live="filterStockStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Items</option>
                                <option value="normal">✓ Normal Stock</option>
                                <option value="low">⚠️ Low Stock</option>
                                <option value="out">❌ Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Category Breakdown -->
                <div class="p-6 border-b border-gray-200 no-print">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Inventory by Category</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categoryStats as $cat)
                            <div class="border border-gray-300 rounded-lg p-4 hover:shadow-md transition">
                                <h4 class="font-semibold text-gray-800">{{ $cat->name }}</h4>
                                <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                                    <div>
                                        <p class="text-gray-600">Products</p>
                                        <p class="text-lg font-bold text-blue-600">{{ $cat->products_count }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Total Stock</p>
                                        <p class="text-lg font-bold text-green-600">{{ $cat->products_sum_current_stock ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-200">
                                    <p class="text-gray-600 text-xs">Value</p>
                                    <p class="font-bold text-purple-600">₱{{ number_format($cat->products_sum_total_cost ?? 0, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Supplier Breakdown -->
                <div class="p-6 border-b border-gray-200 no-print">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Inventory by Supplier</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($supplierStats as $sup)
                            <div class="border border-gray-300 rounded-lg p-4 hover:shadow-md transition">
                                <h4 class="font-semibold text-gray-800">{{ $sup->name }}</h4>
                                <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                                    <div>
                                        <p class="text-gray-600">Products</p>
                                        <p class="text-lg font-bold text-blue-600">{{ $sup->products_count }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Total Stock</p>
                                        <p class="text-lg font-bold text-green-600">{{ $sup->products_sum_current_stock ?? 0 }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-200">
                                    <p class="text-gray-600 text-xs">Value</p>
                                    <p class="font-bold text-purple-600">₱{{ number_format($sup->products_sum_total_cost ?? 0, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Inventory Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b border-gray-300">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Product Name</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">SKU</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Barcode</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Category</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Supplier</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Cost Price</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Sell Price</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Stock</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Reorder Lvl</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-700">Total Value</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                @php
                                    $totalValue = $product->current_stock * $product->cost_price;
                                    $statusClass = $product->current_stock <= 0
                                        ? 'bg-red-50 text-red-700'
                                        : ($product->current_stock <= $product->reorder_level
                                            ? 'bg-yellow-50 text-yellow-700'
                                            : 'bg-green-50 text-green-700');
                                    $statusText = $product->current_stock <= 0
                                        ? 'Out'
                                        : ($product->current_stock <= $product->reorder_level
                                            ? 'Low'
                                            : 'OK');
                                @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-blue-600 cursor-pointer hover:underline" wire:click="showProductModal({{ $product->id }})">{{ $product->name }}</td>
                                    <td class="px-4 py-3 text-gray-600 font-mono">{{ $product->sku }}</td>
                                    <td class="px-4 py-3 text-center text-gray-600 font-mono text-xs">{{ $product->barcode ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $product->category?->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $product->supplier?->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-right text-gray-800">₱{{ number_format($product->cost_price, 2) }}</td>
                                    <td class="px-4 py-3 text-right text-gray-800">₱{{ number_format($product->selling_price, 2) }}</td>
                                    <td class="px-4 py-3 text-center font-bold text-gray-800">{{ $product->current_stock }}</td>
                                    <td class="px-4 py-3 text-center text-gray-600">{{ $product->reorder_level }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-800">₱{{ number_format($totalValue, 2) }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-1 rounded font-semibold text-xs {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-4 py-6 text-center text-gray-500">
                                        No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 no-print">
                    {{ $products->links() }}
                </div>

                <!-- Print Footer -->
                <div class="p-4 bg-gray-50 border-t border-gray-200 text-xs text-gray-600 only-print">
                    <p>Generated on: {{ now()->format('M d, Y H:i A') }}</p>
                    <p>Total Products: {{ $totalProducts }} | Total Stock: {{ $totalStock }} units | Total Value: ₱{{ number_format($totalValue, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Modal -->
    @if($showModal && $modalProduct)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">{{ $modalProduct->name }}</h2>
                    <button wire:click="closeModal" class="text-gray-600 hover:text-gray-800 text-2xl leading-none">×</button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Product Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">SKU</p>
                            <p class="text-lg font-bold text-gray-800">{{ $modalProduct->sku }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Barcode</p>
                            <p class="text-lg font-mono text-gray-800">{{ $modalProduct->barcode ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Category</p>
                            <p class="text-lg text-gray-800">{{ $modalProduct->category?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Supplier</p>
                            <p class="text-lg text-gray-800">{{ $modalProduct->supplier?->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Stock & Pricing Info -->
                    <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200">
                        <div class="bg-blue-50 rounded p-3">
                            <p class="text-gray-600 text-sm font-semibold">Current Stock</p>
                            <p class="text-2xl font-bold text-blue-600">{{ $modalProduct->current_stock }}</p>
                        </div>
                        <div class="bg-yellow-50 rounded p-3">
                            <p class="text-gray-600 text-sm font-semibold">Reorder Level</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $modalProduct->reorder_level }}</p>
                        </div>
                        <div class="bg-green-50 rounded p-3">
                            <p class="text-gray-600 text-sm font-semibold">Cost Price</p>
                            <p class="text-lg font-bold text-green-600">₱{{ number_format($modalProduct->cost_price, 2) }}</p>
                        </div>
                        <div class="bg-purple-50 rounded p-3">
                            <p class="text-gray-600 text-sm font-semibold">Selling Price</p>
                            <p class="text-lg font-bold text-purple-600">₱{{ number_format($modalProduct->selling_price, 2) }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($modalProduct->description)
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <p class="text-gray-600 text-sm font-semibold mb-2">Description</p>
                            <p class="text-gray-800">{{ $modalProduct->description }}</p>
                        </div>
                    @endif

                    <!-- Recent Stock Movements -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Stock Movements</h3>
                        @if($modalMovements->count() > 0)
                            <div class="space-y-2">
                                @foreach($modalMovements as $movement)
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded border border-gray-200">
                                        <div>
                                            <p class="font-semibold text-gray-800">
                                                @if($movement->type === 'in')
                                                    <span class="text-green-600">↑ Stock In</span>
                                                @elseif($movement->type === 'out')
                                                    <span class="text-red-600">↓ Stock Out</span>
                                                @else
                                                    <span class="text-blue-600">⟷ Adjustment</span>
                                                @endif
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $movement->created_at->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-lg">{{ $movement->quantity }} units</p>
                                            <p class="text-sm text-gray-600">{{ $movement->old_stock }} → {{ $movement->new_stock }}</p>
                                            @if($movement->reason)
                                                <p class="text-xs text-gray-500 mt-1">{{ $movement->reason }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 text-center py-4">No stock movements recorded</p>
                        @endif
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 text-right">
                    <button wire:click="closeModal" class="px-6 py-2 bg-gray-600 text-white font-semibold rounded hover:bg-gray-700 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
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
@endpush
