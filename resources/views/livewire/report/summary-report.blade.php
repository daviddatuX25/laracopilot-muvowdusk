<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Summary Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Summary
                    </h2>
                    <a href="{{ route('reports.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-sm font-medium">← Back to Dashboard</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <x-inventory.card.stat-card
                        title="Total Products"
                        value="{{ $totalProducts }}"
                        variant="blue"
                    />
                    <x-inventory.card.stat-card
                        title="Total Categories"
                        value="{{ $totalCategories }}"
                        variant="purple"
                    />
                    <x-inventory.card.stat-card
                        title="Total Suppliers"
                        value="{{ $totalSuppliers }}"
                        variant="green"
                    />
                    <x-inventory.card.stat-card
                        title="Total Stock Value"
                        value="₱{{ number_format($totalStockValue, 2) }}"
                        variant="indigo"
                    />
                    <x-inventory.card.stat-card
                        title="Total Stock Units"
                        value="{{ number_format($totalStockUnits) }}"
                        variant="yellow"
                    />
                    <x-inventory.card.stat-card
                        title="Normal Stock"
                        value="{{ $normalStockCount }}"
                        variant="cyan"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <x-inventory.card.stat-card
                        title="Low Stock Items"
                        value="{{ $lowStockCount }}"
                        variant="warning"
                    />
                    <x-inventory.card.stat-card
                        title="Out of Stock"
                        value="{{ $outOfStockCount }}"
                        variant="danger"
                    />
                </div>

                <div class="flex flex-wrap gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <x-inventory.button.button variant="danger" wire:click="exportPdf">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                        </svg>
                        Export as PDF
                    </x-inventory.button.button>
                    <x-inventory.button.button variant="success" wire:click="exportCsv">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                        </svg>
                        Export as CSV
                    </x-inventory.button.button>
                    <a href="{{ route('reports.index') }}">
                        <x-inventory.button.button variant="secondary">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                            Back to Dashboard
                        </x-inventory.button.button>
                    </a>
                </div>
            </x-inventory.card.card>
        </div>
    </div>
</div>
