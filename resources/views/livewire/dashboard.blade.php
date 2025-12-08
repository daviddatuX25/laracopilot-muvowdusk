<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome to your inventory management system</p>
    </div>

    <!-- Primary Actions Section - Stock Adjustment & Product Lookup -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Product Lookup Modal Button -->
        <div class="group md:col-span-2 lg:col-span-1">
            @livewire('product-lookup')
        </div>

        <!-- Stock Adjustment Button -->
        <a href="{{ route('stock-movements.adjust') }}" class="block group">
            <div class="relative h-48 bg-gradient-to-br from-white via-green-50/40 to-white dark:from-gray-800 dark:via-green-950/40 dark:to-gray-800 rounded-lg shadow-lg hover:shadow-2xl transition overflow-hidden border-2 border-green-200 dark:border-green-900 hover:border-green-400 dark:hover:border-green-600">
                <!-- Background accent -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-100 dark:bg-green-900/30 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition"></div>

                <!-- Content -->
                <div class="relative h-full flex flex-col items-center justify-center p-8 text-center">
                    <svg class="w-16 h-16 text-green-600 dark:text-green-400 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Stock Adjustment</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Manage inventory movements</p>
                    <div class="flex items-center gap-1 text-green-600 dark:text-green-400 font-semibold">
                        <span>Go to page</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Restock Planner Button -->
        <a href="{{ route('restock.plans') }}" class="block group">
            <div class="relative h-48 bg-gradient-to-br from-white via-blue-50/40 to-white dark:from-gray-800 dark:via-blue-950/40 dark:to-gray-800 rounded-lg shadow-lg hover:shadow-2xl transition overflow-hidden border-2 border-blue-200 dark:border-blue-900 hover:border-blue-400 dark:hover:border-blue-600">
                <!-- Background accent -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 dark:bg-blue-900/30 rounded-full -mr-16 -mt-16 opacity-50 group-hover:scale-110 transition"></div>

                <!-- Content -->
                <div class="relative h-full flex flex-col items-center justify-center p-8 text-center">
                    <svg class="w-16 h-16 text-blue-600 dark:text-blue-400 mb-4 group-hover:scale-110 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                        <path d="M351.9 329.506H206.81l-3.072-12.56H368.16l26.63-116.019-217.23-26.04-9.952-58.09h-50.4v21.946h31.894l35.233 191.246a32.927 32.927 0 1 0 36.363 21.462h100.244a32.825 32.825 0 1 0 30.957-21.945zM181.427 197.45l186.51 22.358-17.258 75.195H198.917z"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Restock Planner</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Plan your restocking orders</p>
                    <div class="flex items-center gap-1 text-blue-600 dark:text-blue-400 font-semibold">
                        <span>Go to page</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Top KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-4">
        <!-- Total Products Card -->
        <div class="bg-gradient-to-br from-white via-blue-50/30 to-white dark:from-gray-800 dark:via-blue-950/30 dark:to-gray-800 rounded-lg shadow p-6 border-l-4 border-blue-500 dark:border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalProducts }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9-4v4m0 0v4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stock Quantity Card -->
        <div class="bg-gradient-to-br from-white via-green-50/30 to-white dark:from-gray-800 dark:via-green-950/30 dark:to-gray-800 rounded-lg shadow p-6 border-l-4 border-green-500 dark:border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Stock Units</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalStockQuantity) }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inventory Value Card -->
        <div class="bg-gradient-to-br from-white via-purple-50/30 to-white dark:from-gray-800 dark:via-purple-950/30 dark:to-gray-800 rounded-lg shadow p-6 border-l-4 border-purple-500 dark:border-purple-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Inventory Value</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">₱{{ number_format($totalInventoryValue, 2) }}</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Critical Alerts Card -->
        <div class="bg-gradient-to-br from-white via-red-50/30 to-white dark:from-gray-800 dark:via-red-950/30 dark:to-gray-800 rounded-lg shadow p-6 border-l-4 border-red-500 dark:border-red-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Critical Alerts</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $urgentAlerts }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">{{ $activeAlerts }} total active</p>
                </div>
                <div class="bg-red-100 dark:bg-red-900/30 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary KPI Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Out of Stock Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-orange-500 dark:border-orange-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Out of Stock</p>
                    <p class="text-2xl font-bold text-orange-600 dark:text-orange-400 mt-1">{{ $outOfStockProducts }}</p>
                </div>
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>

        <!-- Low Stock Products Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border-l-4 border-yellow-500 dark:border-yellow-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Low Stock</p>
                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $lowStockProducts }}</p>
                </div>
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m7.939-11a8 8 0 10-11.878 0M9 19H7a2 2 0 01-2-2v-4a2 2 0 012-2h2"/>
                </svg>
            </div>
        </div>

        <!-- Categories & Suppliers Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div class="grid grid-cols-2 gap-3">
                <div class="border-l-4 border-indigo-500 dark:border-indigo-600 pl-3">
                    <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Categories</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalCategories }}</p>
                </div>
                <div class="border-l-4 border-cyan-500 dark:border-cyan-600 pl-3">
                    <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Suppliers</p>
                    <p class="text-2xl font-bold text-cyan-600 dark:text-cyan-400">{{ $totalSuppliers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Left Column: Quick Actions & Critical Alerts -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quick Actions Card -->
            <div class="backdrop-blur-md bg-white/40 dark:bg-gray-800/40 rounded-lg shadow overflow-hidden border border-white/60 dark:border-gray-700/60">
                <div class="bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 dark:from-violet-600 dark:via-purple-600 dark:to-indigo-600 px-6 py-4 border-b border-violet-300/50 dark:border-violet-700/50">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <h2 class="text-lg font-bold text-white">Quick Actions</h2>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-2 gap-3 bg-white/20 dark:bg-gray-800/20 backdrop-blur-xl">
                    <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-lg border-2 border-blue-200/50 dark:border-blue-800/50 hover:border-blue-400/70 dark:hover:border-blue-600/70 bg-blue-50/30 dark:bg-blue-950/20 hover:bg-blue-100/40 dark:hover:bg-blue-900/30 transition group backdrop-blur-sm">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-center">Add Product</span>
                    </a>
                    <a href="{{ route('categories.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-lg border-2 border-purple-200/50 dark:border-purple-800/50 hover:border-purple-400/70 dark:hover:border-purple-600/70 bg-purple-50/30 dark:bg-purple-950/20 hover:bg-purple-100/40 dark:hover:bg-purple-900/30 transition group backdrop-blur-sm">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-center">Add Category</span>
                    </a>
                    <a href="{{ route('suppliers.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-lg border-2 border-green-200/50 dark:border-green-800/50 hover:border-green-400/70 dark:hover:border-green-600/70 bg-green-50/30 dark:bg-green-950/20 hover:bg-green-100/40 dark:hover:bg-green-900/30 transition group backdrop-blur-sm">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white text-center">Add Supplier</span>
                    </a>
                </div>
            </div>

            <!-- Critical Alerts Section -->
            <div class="backdrop-blur-md bg-white/40 dark:bg-gray-800/40 rounded-lg shadow border border-white/60 dark:border-gray-700/60">
                <div class="px-4 md:px-6 py-4 border-b border-violet-300/50 dark:border-violet-700/50 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 dark:from-violet-600 dark:via-purple-600 dark:to-indigo-600 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m0-17a9 9 0 110 18 9 9 0 010-18z"/>
                        </svg>
                        <h2 class="text-lg font-bold text-white">Critical Alerts</h2>
                    </div>
                    <a href="{{ route('alerts.index') }}" class="text-xs md:text-sm text-white hover:text-violet-100 font-medium transition">View All →</a>
                </div>
                <div class="divide-y divide-violet-200/20 dark:divide-violet-800/20 max-h-96 overflow-y-auto bg-white/10 dark:bg-gray-800/10 backdrop-blur-xl">
                    @forelse ($unresolvedAlerts as $alert)
                        <div wire:click="markAlertAsSeen({{ $alert->id }})" class="px-4 md:px-6 py-4 hover:bg-white/50 dark:hover:bg-gray-700/50 transition cursor-pointer {{ !$alert->isSeen() ? 'bg-blue-100/30 dark:bg-blue-900/30' : '' }} backdrop-blur-sm">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0 mt-1 flex items-center gap-2">
                                    @if (!$alert->isSeen())
                                        <div class="w-3 h-3 bg-red-600 dark:bg-red-400 rounded-full"></div>
                                    @endif
                                    @if ($alert->type === 'out_of_stock')
                                        <span class="inline-block px-2 py-1 bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 text-xs font-semibold rounded-full">OUT OF STOCK</span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300 text-xs font-semibold rounded-full">LOW STOCK</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">{{ $alert->product->name ?? 'Unknown Product' }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $alert->message }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $alert->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">No active alerts</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Products Section -->
            <div class="backdrop-blur-md bg-white/40 dark:bg-gray-800/40 rounded-lg shadow border border-white/60 dark:border-gray-700/60">
                <div class="px-4 md:px-6 py-4 border-b border-violet-300/50 dark:border-violet-700/50 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 dark:from-violet-600 dark:via-purple-600 dark:to-indigo-600 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2m0 5v2m7.939-11a8 8 0 10-11.878 0M9 19H7a2 2 0 01-2-2v-4a2 2 0 012-2h2"/>
                        </svg>
                        <h2 class="text-lg font-bold text-white">Low Stock Products</h2>
                    </div>
                    <a href="{{ route('reports.low-stock') }}" class="text-xs md:text-sm text-white hover:text-violet-100 font-medium transition">View Report →</a>
                </div>
                <div class="overflow-x-auto scrollbar-hide bg-white/10 dark:bg-gray-800/10 backdrop-blur-xl">
                    <x-inventory.table.table>
                        <x-inventory.table.table-header :columns="['Product', 'Category', 'Current', 'Reorder']" />
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($lowStockList as $product)
                                <x-inventory.table.table-row>
                                    <x-inventory.table.table-cell>
                                        <div class="font-medium text-gray-900 dark:text-white truncate">{{ $product->name }}</div>
                                    </x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>
                                        <div class="text-gray-600 dark:text-gray-400">{{ $product->category?->name ?? 'N/A' }}</div>
                                    </x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>
                                        <span class="inline-block px-2 md:px-3 py-1 {{ $product->current_stock == 0 ? 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300' : 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300' }} text-xs font-semibold rounded-full">
                                            {{ $product->current_stock }}
                                        </span>
                                    </x-inventory.table.table-cell>
                                    <x-inventory.table.table-cell>
                                        <div class="text-gray-600 dark:text-gray-400">{{ $product->reorder_level }}</div>
                                    </x-inventory.table.table-cell>
                                </x-inventory.table.table-row>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 md:px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        All products are well stocked
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-inventory.table.table>
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Activity & Top Categories -->
        <div class="space-y-6 lg:col-span-2">
            <!-- Recent Stock Movements -->
            <div class="backdrop-blur-md bg-white/40 dark:bg-gray-800/40 rounded-lg shadow border border-white/60 dark:border-gray-700/60">
                <div class="px-6 py-4 border-b border-violet-300/50 dark:border-violet-700/50 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 dark:from-violet-600 dark:via-purple-600 dark:to-indigo-600 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h2 class="text-lg font-bold text-white">Recent Activity</h2>
                    </div>
                    <a href="{{ route('reports.movement-history') }}" class="text-xs md:text-sm text-white hover:text-violet-100 font-medium transition">Explore more →</a>
                </div>
                <div class="divide-y divide-violet-200/20 dark:divide-violet-800/20 max-h-96 overflow-y-auto scrollbar-hide bg-white/10 dark:bg-gray-800/10 backdrop-blur-xl">
                    @forelse ($recentMovements as $movement)
                        <div class="px-6 py-3 hover:bg-white/50 dark:hover:bg-gray-700/50 transition backdrop-blur-sm">
                            <div class="flex items-center gap-2">
                                <div class="shrink-0">
                                    @if ($movement->type === 'in')
                                        <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 text-xs font-semibold rounded">IN</span>
                                    @elseif ($movement->type === 'out')
                                        <span class="inline-block px-2 py-1 bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300 text-xs font-semibold rounded">OUT</span>
                                    @else
                                        <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 text-xs font-semibold rounded">ADJ</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $movement->product?->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $movement->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="shrink-0 text-right">
                                    @if ($movement->type === 'in')
                                        <p class="text-sm font-bold text-green-600 dark:text-green-400">
                                            +{{ $movement->quantity }}
                                        </p>
                                    @elseif ($movement->type === 'out')
                                        <p class="text-sm font-bold text-red-600 dark:text-red-400">
                                            -{{ $movement->quantity }}
                                        </p>
                                    @else
                                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                            ↻ {{ $movement->quantity }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            No recent activity
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Top Categories -->
            <div class="backdrop-blur-md bg-white/40 dark:bg-gray-800/40 rounded-lg shadow border border-white/60 dark:border-gray-700/60">
                <div class="px-6 py-4 border-b border-violet-300/50 dark:border-violet-700/50 bg-gradient-to-r from-violet-400 via-purple-400 to-indigo-400 dark:from-violet-600 dark:via-purple-600 dark:to-indigo-600 flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-white">Top Categories</h2>
                </div>
                <div class="divide-y divide-violet-200/20 dark:divide-violet-800/20 bg-white/10 dark:bg-gray-800/10 backdrop-blur-xl">
                    @forelse ($topCategories as $category)
                        <div class="px-6 py-4 hover:bg-white/50 dark:hover:bg-gray-700/50 transition backdrop-blur-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</p>
                                <span class="inline-block px-2 py-1 bg-gradient-to-r from-violet-100 to-purple-100 dark:from-violet-900/40 dark:to-purple-900/40 text-violet-800 dark:text-violet-300 text-xs font-semibold rounded-full">
                                    {{ $category->products_count }} items
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            No categories yet
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
