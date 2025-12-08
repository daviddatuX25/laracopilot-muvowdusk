<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-violet-100 leading-tight">
            {{ __('Reports Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
                <x-inventory.card.stat-card
                    title="Total Products"
                    value="{{ $stats['total_products'] }}"
                    variant="blue"
                />
                <x-inventory.card.stat-card
                    title="Total Stock Value"
                    value="₱{{ number_format($stats['total_stock_value'], 2) }}"
                    variant="green"
                />
                <x-inventory.card.stat-card
                    title="Low Stock Items"
                    value="{{ $stats['low_stock_count'] }}"
                    variant="yellow"
                />
                <x-inventory.card.stat-card
                    title="Out of Stock"
                    value="{{ $stats['out_of_stock_count'] }}"
                    variant="red"
                />
            </div>

            <!-- Reports Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Inventory Reports -->
                <x-inventory.card.card class="border-t-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📦 Inventory Reports</h3>
                    <div class="space-y-2">
                        <a href="{{ route('reports.full-inventory') }}" class="block p-3 rounded bg-gray-50 dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-gray-600 transition text-gray-700 dark:text-gray-200">
                            <div class="font-semibold text-gray-900 dark:text-white">Full Inventory</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Detailed product listing & filtering</div>
                        </a>
                        <a href="{{ route('reports.low-stock') }}" class="block p-3 rounded bg-gray-50 dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-gray-600 transition text-gray-700 dark:text-gray-200">
                            <div class="font-semibold text-gray-900 dark:text-white">Low Stock Alert</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ $stats['low_stock_count'] }} products below reorder level</div>
                        </a>
                    </div>
                </x-inventory.card.card>

                <!-- Movement Reports -->
                <x-inventory.card.card class="border-t-4 border-purple-500">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📊 Movement Reports</h3>
                    <div class="space-y-2">
                        <a href="{{ route('reports.movement-history') }}" class="block p-3 rounded bg-gray-50 dark:bg-gray-700 hover:bg-purple-50 dark:hover:bg-gray-600 transition text-gray-700 dark:text-gray-200">
                            <div class="font-semibold text-gray-900 dark:text-white">Movement History</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Complete stock transaction log</div>
                        </a>
                        <div class="p-3 rounded bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm">
                            <div class="font-semibold">Trend Analysis</div>
                            <div class="text-xs">Coming soon</div>
                        </div>
                    </div>
                </x-inventory.card.card>

                <!-- Analysis Reports -->
                <x-inventory.card.card class="border-t-4 border-teal-500">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📈 Analysis Reports</h3>
                    <div class="space-y-2">
                        <div class="p-3 rounded bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm">
                            <div class="font-semibold">By Category</div>
                            <div class="text-xs">Coming soon</div>
                        </div>
                        <div class="p-3 rounded bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 text-sm">
                            <div class="font-semibold">By Supplier</div>
                            <div class="text-xs">Coming soon</div>
                        </div>
                    </div>
                </x-inventory.card.card>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                <x-inventory.card.stat-card
                    title="Total Stock Units"
                    value="{{ number_format($stats['total_stock_units']) }}"
                    variant="indigo"
                />
                <x-inventory.card.stat-card
                    title="Categories"
                    value="{{ $stats['total_categories'] }}"
                    variant="purple"
                />
                <x-inventory.card.stat-card
                    title="Suppliers"
                    value="{{ $stats['total_suppliers'] }}"
                    variant="cyan"
                />
            </div>
        </div>
    </div>
</div>
