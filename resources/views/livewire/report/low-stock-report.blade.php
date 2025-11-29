<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Low Stock Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">Low Stock Products</h3>
                        <a href="{{ route('reports.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">← Back to Dashboard</a>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                        <input type="text"
                            wire:model.live="search"
                            placeholder="Search by name or SKU..."
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">

                        <select wire:model.live="filterCategory" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>

                        <select wire:model.live="filterSupplier" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                            @endforeach
                        </select>

                        <div class="flex gap-2 md:col-span-3 lg:col-span-1">
                            <button wire:click="exportPdf" class="flex-1 px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 text-sm font-semibold">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg> PDF
                            </button>
                            <button wire:click="exportCsv" class="flex-1 px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-500 text-sm font-semibold">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg> CSV
                            </button>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        @if ($products->isEmpty())
                            <div class="p-6 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p>No low stock products found.</p>
                            </div>
                        @else
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Product</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">SKU</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Current Stock</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Reorder Level</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Deficit</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Category</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Supplier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm">{{ $product->name }}</td>
                                            <td class="px-4 py-3 text-sm font-mono text-gray-600">{{ $product->sku }}</td>
                                            <td class="px-4 py-3 text-sm font-bold text-orange-600">{{ $product->current_stock }}</td>
                                            <td class="px-4 py-3 text-sm">{{ $product->reorder_level }}</td>
                                            <td class="px-4 py-3 text-sm font-bold text-red-600">{{ $product->reorder_level - $product->current_stock }}</td>
                                            <td class="px-4 py-3 text-sm">{{ $product->category?->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm">{{ $product->supplier?->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
