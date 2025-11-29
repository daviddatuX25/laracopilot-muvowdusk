<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Summary Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl font-bold">
                        Inventory Summary Report
                    </div>

                    <div class="mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h3 class="text-sm font-medium text-blue-900">Total Products</h3>
                                <p class="text-3xl font-extrabold text-blue-600 mt-2">{{ $totalProducts }}</p>
                            </div>
                            <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                                <h3 class="text-sm font-medium text-purple-900">Total Categories</h3>
                                <p class="text-3xl font-extrabold text-purple-600 mt-2">{{ $totalCategories }}</p>
                            </div>
                            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                <h3 class="text-sm font-medium text-green-900">Total Suppliers</h3>
                                <p class="text-3xl font-extrabold text-green-600 mt-2">{{ $totalSuppliers }}</p>
                            </div>
                            <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                                <h3 class="text-sm font-medium text-indigo-900">Total Stock Value</h3>
                                <p class="text-3xl font-extrabold text-indigo-600 mt-2">₱{{ number_format($totalStockValue, 2) }}</p>
                            </div>
                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <h3 class="text-sm font-medium text-yellow-900">Total Stock Units</h3>
                                <p class="text-3xl font-extrabold text-yellow-600 mt-2">{{ number_format($totalStockUnits) }}</p>
                            </div>
                            <div class="p-4 bg-orange-50 rounded-lg border border-orange-200">
                                <h3 class="text-sm font-medium text-orange-900">Normal Stock</h3>
                                <p class="text-3xl font-extrabold text-orange-600 mt-2">{{ $normalStockCount }}</p>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <h3 class="text-sm font-medium text-yellow-900">Low Stock Items</h3>
                                <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $lowStockCount }}</p>
                            </div>
                            <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                                <h3 class="text-sm font-medium text-red-900">Out of Stock</h3>
                                <p class="text-2xl font-bold text-red-600 mt-1">{{ $outOfStockCount }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <button wire:click="exportPdf" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg>
                                Export as PDF
                            </button>
                            <button wire:click="exportCsv" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg>
                                Export as CSV
                            </button>
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
