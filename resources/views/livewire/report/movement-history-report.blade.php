<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Movement History Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-end gap-4">
                <a href="{{ route('reports.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-sm font-medium">← Back to Dashboard</a>
            </div>

            <!-- Filter Section -->
            <x-inventory.card.card class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters & Export</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="sm:col-span-2">
                        <x-inventory.form.form-input-with-icon
                            name="search"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search product..."
                            label="Product"
                            icon="search"
                        />
                    </div>

                    <div class="sm:col-span-1">
                        <x-inventory.form.form-select
                            name="filterType"
                            wire:model.live="filterType"
                            label="Movement Type"
                        >
                            <option value="">All Types</option>
                            <option value="in">📥 Stock In</option>
                            <option value="out">📤 Stock Out</option>
                            <option value="adjustment">⚙️ Adjustment</option>
                        </x-inventory.form.form-select>
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                        <input type="date"
                            wire:model.live="startDate"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                    </div>

                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                        <input type="date"
                            wire:model.live="endDate"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Export</label>
                        <div class="flex gap-2">
                            <x-inventory.button.button variant="danger" size="sm" wire:click="exportPdf" class="flex-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                                <span class="hidden sm:inline">PDF</span>
                            </x-inventory.button.button>
                            <x-inventory.button.button variant="success" size="sm" wire:click="exportCsv" class="flex-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                                <span class="hidden sm:inline">CSV</span>
                            </x-inventory.button.button>
                        </div>
                    </div>
                </div>
            </x-inventory.card.card>

            <!-- Summary Stats -->
            @if (!$movements->isEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <x-inventory.card.stat-card
                        title="Stock In"
                        value="{{ $movements->where('type', 'in')->count() }}"
                        variant="green"
                    />
                    <x-inventory.card.stat-card
                        title="Stock Out"
                        value="{{ $movements->where('type', 'out')->count() }}"
                        variant="red"
                    />
                    <x-inventory.card.stat-card
                        title="Adjustments"
                        value="{{ $movements->where('type', 'adjustment')->count() }}"
                        variant="blue"
                    />
                    <x-inventory.card.stat-card
                        title="Total Movements"
                        value="{{ $movements->count() }}"
                        variant="purple"
                    />
                </div>
            @endif

            <!-- Content Section -->
            <x-inventory.card.card>
                @if ($movements->isEmpty())
                    <x-inventory.state.empty-state
                        title="No movements found"
                        message="Try adjusting your filters to see results"
                    />
                @else
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <x-inventory.table.table>
                            <x-inventory.table.table-header :columns="['Date & Time', 'Product', 'Type', 'Quantity', 'Before', 'After', 'Reason']" />

                            @foreach ($movements as $movement)
                                <x-inventory.table.table-row>
                                    <x-inventory.table.table-cell>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $movement->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $movement->created_at->format('H:i:s') }}</div>
                                    </x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="font-medium text-gray-900 dark:text-gray-100">{{ $movement->product->name }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>
                                        @if($movement->type === 'in')
                                            <x-inventory.badge.badge variant="success">📥 In</x-inventory.badge.badge>
                                        @elseif($movement->type === 'out')
                                            <x-inventory.badge.badge variant="danger">📤 Out</x-inventory.badge.badge>
                                        @else
                                            <x-inventory.badge.badge variant="info">⚙️ Adj</x-inventory.badge.badge>
                                        @endif
                                    </x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-center font-bold text-indigo-600 dark:text-indigo-400">{{ $movement->quantity }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-center text-gray-700 dark:text-gray-300">{{ $movement->old_stock }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-center font-bold text-indigo-600 dark:text-indigo-400">{{ $movement->new_stock }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-gray-600 dark:text-gray-400">{{ $movement->reason ?? '-' }}</x-inventory.table.table-cell>
                                </x-inventory.table.table-row>
                            @endforeach
                        </x-inventory.table.table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($movements as $movement)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $movement->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $movement->created_at->format('H:i:s') }}</p>
                                    </div>
                                    @if($movement->type === 'in')
                                        <x-inventory.badge.badge variant="success">📥 In</x-inventory.badge.badge>
                                    @elseif($movement->type === 'out')
                                        <x-inventory.badge.badge variant="danger">📤 Out</x-inventory.badge.badge>
                                    @else
                                        <x-inventory.badge.badge variant="info">⚙️ Adj</x-inventory.badge.badge>
                                    @endif
                                </div>

                                <h4 class="font-bold text-gray-900 dark:text-white mb-3">{{ $movement->product->name }}</h4>

                                <div class="grid grid-cols-3 gap-2 mb-3 bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                    <div class="text-center">
                                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Quantity</p>
                                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $movement->quantity }}</p>
                                    </div>
                                    <div class="text-center border-l border-r border-gray-300 dark:border-gray-600">
                                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Before</p>
                                        <p class="text-lg font-bold text-gray-700 dark:text-gray-300">{{ $movement->old_stock }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">After</p>
                                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $movement->new_stock }}</p>
                                    </div>
                                </div>

                                @if($movement->reason)
                                    <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Reason</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-2 rounded">{{ $movement->reason }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $movements->links() }}
                    </div>
                @endif
            </x-inventory.card.card>
        </div>
    </div>
</div>
