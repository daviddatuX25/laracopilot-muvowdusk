<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movement History Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">Stock Movement History</h3>
                        <a href="{{ route('reports.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">← Back to Dashboard</a>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3 mb-6">
                        <input type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Search product..." 
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                        
                        <select wire:model.live="filterType" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">All Types</option>
                            <option value="in">In</option>
                            <option value="out">Out</option>
                            <option value="adjustment">Adjustment</option>
                        </select>

                        <input type="date" 
                            wire:model.live="startDate" 
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">

                        <input type="date" 
                            wire:model.live="endDate" 
                            class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">

                        <div class="flex gap-2">
                            <button wire:click="exportPdf" class="flex-1 px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 text-xs font-semibold">PDF</button>
                            <button wire:click="exportCsv" class="flex-1 px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-500 text-xs font-semibold">CSV</button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        @if ($movements->isEmpty())
                            <div class="p-6 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p>No movements found.</p>
                            </div>
                        @else
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Date & Time</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Product</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Type</th>
                                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Qty</th>
                                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Before</th>
                                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">After</th>
                                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movements as $movement)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-2 text-sm text-gray-600">
                                                <div>{{ $movement->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $movement->created_at->format('H:i:s') }}</div>
                                            </td>
                                            <td class="px-4 py-2 text-sm font-medium">{{ $movement->product->name }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($movement->type === 'in') bg-green-100 text-green-800
                                                    @elseif($movement->type === 'out') bg-red-100 text-red-800
                                                    @else bg-blue-100 text-blue-800
                                                    @endif">
                                                    {{ ucfirst($movement->type) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-sm text-center font-semibold">{{ $movement->quantity }}</td>
                                            <td class="px-4 py-2 text-sm text-center">{{ $movement->old_stock }}</td>
                                            <td class="px-4 py-2 text-sm text-center font-semibold text-indigo-600">{{ $movement->new_stock }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-600">{{ $movement->reason ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                {{ $movements->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
