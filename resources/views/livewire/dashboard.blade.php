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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Products Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalProducts }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9-4v4m0 0v4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stock Quantity Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Stock Units</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalStockQuantity) }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Inventory Value Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Inventory Value</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($totalInventoryValue, 2) }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Critical Alerts Card -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Critical Alerts</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">{{ $urgentAlerts }}</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $activeAlerts }} total active</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary KPI Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Out of Stock Card -->
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Out of Stock</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">{{ $outOfStockProducts }}</p>
                </div>
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>

        <!-- Low Stock Products Card -->
        <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Low Stock</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $lowStockProducts }}</p>
                </div>
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m7.939-11a8 8 0 10-11.878 0M9 19H7a2 2 0 01-2-2v-4a2 2 0 012-2h2"/>
                </svg>
            </div>
        </div>

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
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900">Quick Actions</h2>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-2 gap-3">
                    <a href="{{ route('products.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-lg border-2 border-blue-200 hover:border-blue-400 hover:bg-blue-50 transition group">
                        <svg class="w-8 h-8 text-blue-600 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-900 text-center">Add Product</span>
                    </a>
                    <a href="{{ route('categories.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-lg border-2 border-purple-200 hover:border-purple-400 hover:bg-purple-50 transition group">
                        <svg class="w-8 h-8 text-purple-600 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-900 text-center">Add Category</span>
                    </a>
                    <a href="{{ route('suppliers.create') }}" class="flex flex-col items-center justify-center gap-2 p-4 rounded-lg border-2 border-green-200 hover:border-green-400 hover:bg-green-50 transition group">
                        <svg class="w-8 h-8 text-green-600 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-900 text-center">Add Supplier</span>
                    </a>
                </div>
            </div>

            <!-- Critical Alerts Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m0-17a9 9 0 110 18 9 9 0 010-18z"/>
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900">Critical Alerts</h2>
                    </div>
                    <a href="{{ route('alerts.index') }}" class="text-xs md:text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All →</a>
                </div>
                <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                    @forelse ($unresolvedAlerts as $alert)
                        <div wire:click="markAlertAsSeen({{ $alert->id }})" class="px-4 md:px-6 py-4 hover:bg-gray-50 transition cursor-pointer {{ !$alert->isSeen() ? 'bg-blue-50' : '' }}">
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
            </div>

            <!-- Low Stock Products Section -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2m0 5v2m7.939-11a8 8 0 10-11.878 0M9 19H7a2 2 0 01-2-2v-4a2 2 0 012-2h2"/>
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900">Low Stock Products</h2>
                    </div>
                    <a href="{{ route('reports.low-stock') }}" class="text-xs md:text-sm text-indigo-600 hover:text-indigo-800 font-medium">View Report →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs md:text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-3 md:px-6 py-3 text-left font-semibold text-gray-700">Product</th>
                                <th class="px-3 md:px-6 py-3 text-left font-semibold text-gray-700 hidden md:table-cell">Category</th>
                                <th class="px-3 md:px-6 py-3 text-left font-semibold text-gray-700">Current</th>
                                <th class="px-3 md:px-6 py-3 text-left font-semibold text-gray-700">Reorder</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($lowStockList as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-3 md:px-6 py-4 font-medium text-gray-900 truncate">{{ $product->name }}</td>
                                    <td class="px-3 md:px-6 py-4 text-gray-600 hidden md:table-cell">{{ $product->category?->name ?? 'N/A' }}</td>
                                    <td class="px-3 md:px-6 py-4">
                                        <span class="inline-block px-2 md:px-3 py-1 {{ $product->current_stock == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }} text-xs font-semibold rounded-full">
                                            {{ $product->current_stock }}
                                        </span>
                                    </td>
                                    <td class="px-3 md:px-6 py-4 text-gray-600">{{ $product->reorder_level }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 md:px-6 py-8 text-center text-gray-500">
                                        All products are well stocked
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Recent Activity & Top Categories -->
        <div class="space-y-6">
            <!-- Recent Stock Movements -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900">Recent Activity</h2>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                    @forelse ($recentMovements as $movement)
                        <div class="px-6 py-3 hover:bg-gray-50 transition">
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
            </div>

            <!-- Top Categories -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                    </svg>
                    <h2 class="text-lg font-bold text-gray-900">Top Categories</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($topCategories as $category)
                        <div class="px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>
                                <span class="inline-block px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    {{ $category->products_count }} items
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            No categories yet
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
