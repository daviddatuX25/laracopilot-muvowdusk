<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Products</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_products'] }}</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042L5.960 9H9a2 2 0 100-4H6.022A2.999 2.999 0 003 1zm14 16v2H3v-2H1v-2h18v2h-2z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Stock Value</p>
                            <p class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($stats['total_stock_value'], 2) }}</p>
                        </div>
                        <svg class="w-12 h-12 text-green-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.16 5a.5.5 0 100 1H12c2.485 0 4.5 1.879 4.5 4.21V12a.5.5 0 00-1 0v-1.79C15.5 8.042 14.053 7 12 7H8.16a.5.5 0 000 1H12c1.933 0 3.5 1.343 3.5 3s-1.567 3-3.5 3H2a.5.5 0 000 1h10c2.15 0 3.957-1.42 3.957-3.21a4.02 4.02 0 00-.04-.464l1.261-2.19a.5.5 0 00-.816-.612l-1.242 2.152C14.859 8.03 13.604 7 12 7H8.16a.5.5 0 000 1H12c1.933 0 3.5 1.343 3.5 3s-1.567 3-3.5 3H2a.5.5 0 000 1h10c2.485 0 4.5-1.879 4.5-4.21V8.21C16.5 6.879 15.485 5 13 5H8.16z"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Low Stock Items</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $stats['low_stock_count'] }}</p>
                        </div>
                        <svg class="w-12 h-12 text-yellow-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Out of Stock</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $stats['out_of_stock_count'] }}</p>
                        </div>
                        <svg class="w-12 h-12 text-red-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 2.523a6 6 0 008.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0zm-1.414-1.414a1 1 0 00-1.414-1.414L10 8.586 7.828 6.414a1 1 0 00-1.414 1.414L8.586 10l-2.172 2.172a1 1 0 101.414 1.414L10 11.414l2.172 2.172a1 1 0 101.414-1.414L11.414 10l2.172-2.172z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Inventory Reports -->
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-white font-bold text-lg">Inventory Reports</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('reports.full-inventory') }}" class="block px-4 py-2 bg-gray-100 hover:bg-blue-50 rounded text-gray-700 hover:text-blue-600 transition">
                            <span class="font-medium">Full Inventory</span>
                            <p class="text-sm text-gray-600">Detailed product listing & filtering</p>
                        </a>
                        <a href="{{ route('reports.low-stock') }}" class="block px-4 py-2 bg-gray-100 hover:bg-blue-50 rounded text-gray-700 hover:text-blue-600 transition">
                            <span class="font-medium">Low Stock Alert</span>
                            <p class="text-sm text-gray-600">{{ $stats['low_stock_count'] }} products below reorder level</p>
                        </a>
                    </div>
                </div>

                <!-- Movement Reports -->
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-white font-bold text-lg">Movement Reports</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('reports.movement-history') }}" class="block px-4 py-2 bg-gray-100 hover:bg-purple-50 rounded text-gray-700 hover:text-purple-600 transition">
                            <span class="font-medium">Movement History</span>
                            <p class="text-sm text-gray-600">Complete stock transaction log</p>
                        </a>
                        <div class="px-4 py-2 bg-gray-50 rounded text-gray-500 text-sm">
                            <p class="font-medium text-gray-400">Trend Analysis</p>
                            <p class="text-xs">Coming soon</p>
                        </div>
                    </div>
                </div>

                <!-- Analysis Reports -->
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                        <h3 class="text-white font-bold text-lg">Analysis Reports</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="px-4 py-2 bg-gray-50 rounded text-gray-500 text-sm">
                            <p class="font-medium text-gray-400">By Category</p>
                            <p class="text-xs">Coming soon</p>
                        </div>
                        <div class="px-4 py-2 bg-gray-50 rounded text-gray-500 text-sm">
                            <p class="font-medium text-gray-400">By Supplier</p>
                            <p class="text-xs">Coming soon</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Total Stock Units</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_stock_units']) }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Categories</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_categories'] }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-medium">Suppliers</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_suppliers'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
