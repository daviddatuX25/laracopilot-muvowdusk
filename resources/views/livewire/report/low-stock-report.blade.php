<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Low Stock Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Products</h3>
                    <a href="{{ route('reports.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-sm font-medium">← Back to Dashboard</a>
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                    <x-inventory.form.form-input-with-icon
                        name="search"
                        wire:model.live="search"
                        placeholder="Search by name or SKU..."
                        icon="search"
                    />

                    <x-inventory.form.form-select
                        name="filterCategory"
                        wire:model.live="filterCategory"
                        class="md:col-span-1"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </x-inventory.form.form-select>

                    <x-inventory.form.form-select
                        name="filterSupplier"
                        wire:model.live="filterSupplier"
                        class="md:col-span-1"
                    >
                        <option value="">All Suppliers</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </x-inventory.form.form-select>

                    <div class="flex gap-2 md:col-span-1">
                        <x-inventory.button.button variant="danger" size="sm" wire:click="exportPdf" class="flex-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                            </svg> PDF
                        </x-inventory.button.button>
                        <x-inventory.button.button variant="success" size="sm" wire:click="exportCsv" class="flex-1">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                            </svg> CSV
                        </x-inventory.button.button>
                    </div>
                </div>

                <!-- Products Table -->
                @if ($products->isEmpty())
                    <x-inventory.state.empty-state
                        title="No low stock products found"
                        message="All your products are well stocked!"
                    />
                @else
                    <div class="overflow-x-auto">
                        <x-inventory.table.table>
                            <x-inventory.table.table-header :columns="['Product', 'SKU', 'Current Stock', 'Reorder Level', 'Deficit', 'Category', 'Supplier']" />

                            @foreach ($products as $product)
                                <x-inventory.table.table-row>
                                    <x-inventory.table.table-cell>{{ $product->name }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="font-mono text-gray-600 dark:text-gray-400">{{ $product->sku }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-center font-bold text-orange-600 dark:text-orange-400">{{ $product->current_stock }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-center">{{ $product->reorder_level }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell class="text-center font-bold text-red-600 dark:text-red-400">{{ $product->reorder_level - $product->current_stock }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>{{ $product->category?->name ?? 'N/A' }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>{{ $product->supplier?->name ?? 'N/A' }}</x-inventory.table.table-cell>
                                </x-inventory.table.table-row>
                            @endforeach
                        </x-inventory.table.table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </x-inventory.card.card>
        </div>
    </div>
</div>
