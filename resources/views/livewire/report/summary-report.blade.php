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
                    <div class="mt-8 text-2xl">
                        Inventory Summary Report
                    </div>

                    <div class="mt-6 text-gray-500">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                                <h3 class="text-lg font-bold">Total Products</h3>
                                <p class="text-3xl font-extrabold text-indigo-600">{{ $totalProducts }}</p>
                            </div>
                            <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                                <h3 class="text-lg font-bold">Total Categories</h3>
                                <p class="text-3xl font-extrabold text-indigo-600">{{ $totalCategories }}</p>
                            </div>
                            <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                                <h3 class="text-lg font-bold">Total Suppliers</h3>
                                <p class="text-3xl font-extrabold text-indigo-600">{{ $totalSuppliers }}</p>
                            </div>
                            <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                                <h3 class="text-lg font-bold">Total Stock Value</h3>
                                <p class="text-3xl font-extrabold text-indigo-600">${{ number_format($totalStockValue, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button wire:click="exportPdf" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red disabled:opacity-25 transition ease-in-out duration-150">
                                Export as PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
