<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movement History Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Stock Movement History
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Search Product:</label>
                            <input type="text" id="search" wire:model.live.debounce.300ms="search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search by name, SKU or barcode">
                        </div>
                        <div>
                            <label for="filterType" class="block text-gray-700 text-sm font-bold mb-2">Movement Type:</label>
                            <select id="filterType" wire:model.live="filterType" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="">All</option>
                                <option value="in">In</option>
                                <option value="out">Out</option>
                                <option value="adjustment">Adjustment</option>
                            </select>
                        </div>
                        <div>
                            <label for="startDate" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                            <input type="date" id="startDate" wire:model.live="startDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="endDate" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                            <input type="date" id="endDate" wire:model.live="endDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button wire:click="exportPdf" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red disabled:opacity-25 transition ease-in-out duration-150">
                            Export as PDF
                        </button>
                    </div>

                    <div class="mt-4 text-gray-500">
                        @if ($movements->isEmpty())
                            <p>No stock movements found with the selected filters.</p>
                        @else
                            <table class="table-auto w-full mt-4">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Date</th>
                                        <th class="px-4 py-2">Product</th>
                                        <th class="px-4 py-2">Type</th>
                                        <th class="px-4 py-2">Quantity</th>
                                        <th class="px-4 py-2">Old Stock</th>
                                        <th class="px-4 py-2">New Stock</th>
                                        <th class="px-4 py-2">Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movements as $movement)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $movement->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="border px-4 py-2">{{ $movement->product->name }}</td>
                                            <td class="border px-4 py-2">{{ ucwords($movement->type) }}</td>
                                            <td class="border px-4 py-2">{{ $movement->quantity }}</td>
                                            <td class="border px-4 py-2">{{ $movement->old_stock }}</td>
                                            <td class="border px-4 py-2">{{ $movement->new_stock }}</td>
                                            <td class="border px-4 py-2">{{ $movement->reason }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $movements->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
