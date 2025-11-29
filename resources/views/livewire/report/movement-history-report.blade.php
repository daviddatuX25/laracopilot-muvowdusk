<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movement History Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-900">Stock Movement History</h1>
                <a href="{{ route('reports.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">← Back to Dashboard</a>
            </div>


            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Filters & Export</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-14 gap-4">
                    <!-- Search Input - 4 cols on lg -->
                    <div class="sm:col-span-2 lg:col-span-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search product..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition">
                        </div>
                    </div>

                    <!-- Type Filter - 2 cols on lg -->
                    <div class="sm:col-span-1 lg:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Movement Type</label>
                        <select wire:model.live="filterType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                            <option value="">All Types</option>
                            <option value="in">📥 Stock In</option>
                            <option value="out">📤 Stock Out</option>
                            <option value="adjustment">⚙️ Adjustment</option>
                        </select>
                    </div>

                    <!-- Start Date - 2 cols on lg -->
                    <div class="sm:col-span-1 lg:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date"
                            wire:model.live="startDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                    </div>

                    <!-- End Date - 2 cols on lg -->
                    <div class="sm:col-span-1 lg:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date"
                            wire:model.live="endDate"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition">
                    </div>

                    <!-- Export Buttons - 2 cols on lg -->
                    <div class="sm:col-span-2 lg:col-span-14">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Export</label>
                        <div class="flex gap-2 h-10">
                            <button wire:click="exportPdf" class="flex-1 px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs font-semibold transition flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                                <span class="hidden sm:inline">PDF</span>
                            </button>
                            <button wire:click="exportCsv" class="flex-1 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-xs font-semibold transition flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3 3 0 01-.369-5.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/></svg>
                                <span class="hidden sm:inline">CSV</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>            <!-- Summary Stats -->
            @if (!$movements->isEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                        <p class="text-sm font-medium text-green-700">Stock In</p>
                        <p class="text-2xl font-bold text-green-800">{{ $movements->where('type', 'in')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                        <p class="text-sm font-medium text-red-700">Stock Out</p>
                        <p class="text-2xl font-bold text-red-800">{{ $movements->where('type', 'out')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                        <p class="text-sm font-medium text-blue-700">Adjustments</p>
                        <p class="text-2xl font-bold text-blue-800">{{ $movements->where('type', 'adjustment')->count() }}</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                        <p class="text-sm font-medium text-purple-700">Total Movements</p>
                        <p class="text-2xl font-bold text-purple-800">{{ $movements->count() }}</p>
                    </div>
                </div>
            @endif

            <!-- Content Section -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if ($movements->isEmpty())
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xl text-gray-500 font-medium">No movements found</p>
                        <p class="text-gray-400 mt-2">Try adjusting your filters to see results</p>
                    </div>
                @else
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Before</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">After</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Reason</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($movements as $movement)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-medium text-gray-900">{{ $movement->created_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $movement->created_at->format('H:i:s') }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $movement->product->name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($movement->type === 'in')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2.414l-1.707-1.707a1 1 0 111.414-1.414l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L5.414 11H3a1 1 0 01-1-1z"/></svg>
                                                    In
                                                </span>
                                            @elseif($movement->type === 'out')
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 11a1 1 0 01-1 1h-2.414l1.707 1.707a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 111.414 1.414L14.586 11H17a1 1 0 011 1z"/></svg>
                                                    Out
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                                    Adj
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-center font-bold text-indigo-600">{{ $movement->quantity }}</td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $movement->old_stock }}</td>
                                        <td class="px-6 py-4 text-sm text-center font-bold text-indigo-600">{{ $movement->new_stock }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $movement->reason ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden divide-y divide-gray-200">
                        @foreach ($movements as $movement)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <!-- Top Section: Type Badge and Date -->
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $movement->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $movement->created_at->format('H:i:s') }}</p>
                                    </div>
                                    @if($movement->type === 'in')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2.414l-1.707-1.707a1 1 0 111.414-1.414l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L5.414 11H3a1 1 0 01-1-1z"/></svg>
                                            In
                                        </span>
                                    @elseif($movement->type === 'out')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 11a1 1 0 01-1 1h-2.414l1.707 1.707a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 111.414 1.414L14.586 11H17a1 1 0 011 1z"/></svg>
                                            Out
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>
                                            Adj
                                        </span>
                                    @endif
                                </div>

                                <!-- Product Name -->
                                <h4 class="font-bold text-gray-900 mb-3">{{ $movement->product->name }}</h4>

                                <!-- Main Stats Grid -->
                                <div class="grid grid-cols-3 gap-2 mb-3 bg-gray-50 rounded-lg p-3">
                                    <div class="text-center">
                                        <p class="text-xs font-medium text-gray-600 mb-1">Quantity</p>
                                        <p class="text-lg font-bold text-indigo-600">{{ $movement->quantity }}</p>
                                    </div>
                                    <div class="text-center border-l border-r border-gray-300">
                                        <p class="text-xs font-medium text-gray-600 mb-1">Before</p>
                                        <p class="text-lg font-bold text-gray-700">{{ $movement->old_stock }}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs font-medium text-gray-600 mb-1">After</p>
                                        <p class="text-lg font-bold text-indigo-600">{{ $movement->new_stock }}</p>
                                    </div>
                                </div>

                                <!-- Reason Section -->
                                @if($movement->reason)
                                    <div class="pt-3 border-t border-gray-200">
                                        <p class="text-xs font-medium text-gray-600 mb-1">Reason</p>
                                        <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded">{{ $movement->reason }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $movements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
