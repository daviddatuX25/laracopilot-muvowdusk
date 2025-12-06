<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-1">Welcome to your inventory management system</p>
    </div>

    <!-- Primary Actions Section - Stock Adjustment & Product Lookup -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Stock Adjustment Button -->
        <a href="{{ route('stock-movements.adjust') }}" class="block group">
            <div class="relative h-48 bg-white rounded-lg shadow-lg hover:shadow-2xl transition overflow-hidden border-2 border-green-200 hover:border-green-400">
                <!-- Background accent -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-100 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition"></div>

                <!-- Content -->
                <div class="relative h-full flex flex-col items-center justify-center p-8 text-center">
                    <svg class="w-16 h-16 text-green-600 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Stock Adjustment</h2>
                    <p class="text-sm text-gray-600 mb-4">Manage inventory movements</p>
                    <div class="flex items-center gap-1 text-green-600 font-semibold">
                        <span>Go to page</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Product Lookup Modal Button -->
        <div class="group">
            @livewire('product-lookup')
        </div>
    </div>

    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-4">
        <!-- Total Products Card -->
        <x-inventory.card.stat-card
            title="Total Products"
            value="{{ $totalProducts }}"
            color="blue"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9-4v4m0 0v4"/>
        </x-inventory.card.stat-card>

        <!-- Total Stock Quantity Card -->
        <x-inventory.card.stat-card
            title="Total Stock Units"
            value="{{ number_format($totalStockQuantity) }}"
            color="green"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </x-inventory.card.stat-card>

        <!-- Inventory Value Card -->
        <x-inventory.card.stat-card
            title="Inventory Value"
            value="₱{{ number_format($totalInventoryValue, 2) }}"
            color="purple"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
        </x-inventory.card.stat-card>

        <!-- Critical Alerts Card -->
        <x-inventory.card.stat-card
            title="Critical Alerts"
            value="{{ $urgentAlerts }}"
            color="red"
            subtitle="{{ $activeAlerts }} total active"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </x-inventory.card.stat-card>
    </div>

    <!-- Secondary KPI Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Out of Stock Card -->
        <x-inventory.card.stat-card
            title="Out of Stock"
            value="{{ $outOfStockProducts }}"
            color="red"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </x-inventory.card.stat-card>

        <!-- Low Stock Products Card -->
        <x-inventory.card.stat-card
            title="Low Stock"
            value="{{ $lowStockProducts }}"
            color="yellow"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m7.939-11a8 8 0 10-11.878 0M9 19H7a2 2 0 01-2-2v-4a2 2 0 012-2h2"/>
        </x-inventory.card.stat-card>

        <!-- Categories & Suppliers Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="grid grid-cols-2 gap-3">
                <div class="border-l-4 border-indigo-500 pl-3">
                    <p class="text-gray-600 text-xs font-medium">Categories</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $totalCategories }}</p>
                </div>
                <div class="border-l-4 border-cyan-500 pl-3">
                    <p class="text-gray-600 text-xs font-medium">Suppliers</p>
                    <p class="text-2xl font-bold text-cyan-600">{{ $totalSuppliers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Left Column: Quick Actions & Critical Alerts -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quick Actions Card -->
            <x-inventory.card.card title="Quick Actions">
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('products.create') }}" class="block group">
                        <x-inventory.button.button variant="outline" class="w-full justify-start text-left">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>Add Product</span>
                        </x-inventory.button.button>
                    </a>
                    <a href="{{ route('categories.create') }}" class="block group">
                        <x-inventory.button.button variant="outline" class="w-full justify-start text-left">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                            <span>Add Category</span>
                        </x-inventory.button.button>
                    </a>
                    <a href="{{ route('suppliers.create') }}" class="block group">
                        <x-inventory.button.button variant="outline" class="w-full justify-start text-left">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span>Add Supplier</span>
                        </x-inventory.button.button>
                    </a>
                </div>
            </x-inventory.card.card>

            <!-- Critical Alerts Section -->
            <x-inventory.card.card title="Critical Alerts">
                <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                    @forelse ($unresolvedAlerts as $alert)
                        <div wire:click="markAlertAsSeen({{ $alert->id }})" class="px-4 py-4 hover:bg-gray-50 transition cursor-pointer {{ !$alert->isSeen() ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0 mt-1 flex items-center gap-2">
                                    @if (!$alert->isSeen())
                                        <div class="w-3 h-3 bg-red-600 rounded-full"></div>
                                    @endif
                                    @if ($alert->type === 'out_of_stock')
                                        <span class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">OUT OF STOCK</span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">LOW STOCK</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $alert->product->name ?? 'Unknown Product' }}</p>
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $alert->message }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $alert->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500">No active alerts</p>
                        </div>
                    @endforelse
                </div>
            </x-inventory.card.card>

            <!-- Low Stock Products Section -->
            <x-inventory.card.card title="Low Stock Products">
                <div class="overflow-x-auto">
                    <x-inventory.table.table>
                        <x-inventory.table.table-header :columns="['Product', 'Category', 'Current', 'Reorder']" />
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($lowStockList as $product)
                                <x-inventory.table.table-row>
                                    <x-inventory.table.table-cell>{{ $product->name }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>{{ $product->category?->name ?? 'N/A' }}</x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>
                                        <span class="inline-block px-2 py-1 {{ $product->current_stock == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }} text-xs font-semibold rounded-full">
                                            {{ $product->current_stock }}
                                        </span>
                                    </x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>{{ $product->reorder_level }}</x-inventory.table.table-cell>
                                </x-inventory.table.table-row>
                            @empty
                                <x-inventory.table.table-empty :colSpan="4" message="All products are well stocked" />
                            @endforelse
                        </tbody>
                    </x-inventory.table.table>
                </div>
            </x-inventory.card.card>
        </div>

        <!-- Right Column: Recent Activity & Top Categories -->
        <div class="space-y-6 lg:col-span-2">
            <!-- Recent Stock Movements -->
            <x-inventory.card.card title="Recent Activity">
                <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                    @forelse ($recentMovements as $movement)
                        <div class="px-4 py-3 hover:bg-gray-50 transition">
                            <div class="flex items-center gap-2">
                                <div class="shrink-0">
                                    @if ($movement->type === 'in')
                                        <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">IN</span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">OUT</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $movement->product?->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-500">{{ $movement->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="shrink-0 text-right">
                                    <p class="text-sm font-bold {{ $movement->type === 'in' ? 'text-green-600' : 'text-blue-600' }}">
                                        {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            No recent activity
                        </div>
                    @endforelse
                </div>
            </x-inventory.card.card>

            <!-- Top Categories -->
            <x-inventory.card.card title="Top Categories">
                <div class="divide-y divide-gray-100">
                    @forelse ($topCategories as $category)
                        <div class="px-4 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>
                                <x-inventory.badge.badge variant="indigo">
                                    {{ $category->products_count }} items
                                </x-inventory.badge.badge>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            No categories yet
                        </div>
                    @endforelse
                </div>
            </x-inventory.card.card>
        </div>
    </div>
</div>
