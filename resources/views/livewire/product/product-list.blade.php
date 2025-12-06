<div x-data="{
    viewMode: 'table',
    init() {
        const stored = localStorage.getItem('productListViewMode');
        if (stored) {
            this.viewMode = stored;
        }
    },
    toggleViewMode() {
        this.viewMode = this.viewMode === 'table' ? 'card' : 'table';
        localStorage.setItem('productListViewMode', this.viewMode);
    }
}" x-cloak @init="init">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <x-inventory.card.card>
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Product List</h1>
                    <div class="flex gap-3">
                        <x-inventory.button.button variant="violet-outline" @click="toggleViewMode" size="sm">
                            <svg x-show="viewMode === 'table'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2h-6a2 2 0 01-2-2V4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6m-6 4h6"/>
                            </svg>
                            <svg x-show="viewMode === 'card'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16"/>
                            </svg>
                            <span x-text="viewMode === 'table' ? 'Card View' : 'Table View'"></span>
                        </x-inventory.button.button>
                        <a href="{{ route('products.create') }}">
                            <x-inventory.button.button variant="violet" size="sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Add New Product
                            </x-inventory.button.button>
                        </a>
                    </div>
                </div>

                @if (session()->has('message'))
                    <x-inventory.state.success-message type="success">
                        {{ session('message') }}
                    </x-inventory.state.success-message>
                @endif

                <!-- Search Bar -->
                <x-inventory.form.form-input-with-icon
                    name="search"
                    type="text"
                    placeholder="Search products by name, SKU, or barcode..."
                    wire:model.live.debounce.300ms="search"
                    icon="search"
                />

                @if ($products->isEmpty())
                    <x-inventory.state.empty-state title="No Products" message="No products found. Create your first product to get started!" />
                @else
                    <!-- Table View -->
                    <div x-show="viewMode === 'table'" x-cloak>
                        <div class="overflow-x-auto">
                            <x-inventory.table.table>
                                <x-inventory.table.table-header :columns="['Image', 'Name', 'SKU', 'Stock', 'Price', 'Actions']" />
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($products as $product)
                                        <x-inventory.table.table-row>
                                            <x-inventory.table.table-cell>
                                                @if ($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-full">
                                                @else
                                                    <div class="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-300 text-xs font-semibold">N/A</div>
                                                @endif
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category?->name ?? 'No Category' }}</div>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ $product->sku }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product->barcode }}</div>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <x-inventory.badge.stock-badge
                                                    status="{{ $product->current_stock == 0 ? 'out_of_stock' : ($product->current_stock <= $product->reorder_level ? 'low_stock' : 'in_stock') }}"
                                                    quantity="{{ $product->current_stock }}"
                                                />
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-cell>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">₱{{ number_format($product->selling_price, 2) }}</div>
                                            </x-inventory.table.table-cell>
                                            <x-inventory.table.table-actions>
                                                <a href="{{ route('products.edit', $product->id) }}" class="text-violet-600 dark:text-violet-400 hover:text-violet-900 dark:hover:text-violet-300 text-sm font-medium">Edit</a>
                                                <button wire:click="delete({{ $product->id }})"
                                                        wire:confirm="Are you sure you want to delete this product?"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm font-medium">Delete</button>
                                            </x-inventory.table.table-actions>
                                        </x-inventory.table.table-row>
                                    @endforeach
                                </tbody>
                            </x-inventory.table.table>
                        </div>
                    </div>

                    <!-- Card View -->
                    <div x-show="viewMode === 'card'" x-cloak>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            @foreach ($products as $product)
                                <x-inventory.card.card>
                                    <!-- Image Section -->
                                    <div class="mb-4">
                                        @if ($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-40 bg-gray-300 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400">No Image</div>
                                        @endif
                                    </div>

                                    <!-- Product Name & Category -->
                                    <div class="mb-3">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category?->name ?? 'No Category' }}</p>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 mb-4 space-y-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">SKU:</span>
                                            <span class="text-gray-900 dark:text-white font-semibold">{{ $product->sku }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Stock:</span>
                                            <x-inventory.badge.stock-badge
                                                status="{{ $product->current_stock == 0 ? 'out_of_stock' : ($product->current_stock <= $product->reorder_level ? 'low_stock' : 'in_stock') }}"
                                                quantity="{{ $product->current_stock }}"
                                            />
                                        </div>
                                        <div class="flex justify-between items-center text-sm pt-2 border-t border-gray-200 dark:border-gray-600">
                                            <span class="font-medium text-gray-700 dark:text-gray-300">Price:</span>
                                            <span class="text-green-600 dark:text-green-400 font-semibold">₱{{ number_format($product->selling_price, 2) }}</span>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    @if ($product->description)
                                        <div class="mb-4">
                                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Description:</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">{{ $product->description }}</p>
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('products.edit', $product->id) }}" class="flex-1">
                                            <x-inventory.button.button variant="violet-outline" size="sm" class="w-full">
                                                Edit
                                            </x-inventory.button.button>
                                        </a>
                                        <button wire:click="delete({{ $product->id }})"
                                                wire:confirm="Are you sure you want to delete this product?"
                                                class="flex-1">
                                            <x-inventory.button.button variant="danger" size="sm" class="w-full">
                                                Delete
                                            </x-inventory.button.button>
                                        </button>
                                    </div>
                                </x-inventory.card.card>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                @endif
            </x-inventory.card.card>
        </div>
    </div>
</div>
