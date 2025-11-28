<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Low Stock Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Low Stock Products
                    </div>

                    <div class="mt-6">
                        <button wire:click="exportPdf" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red disabled:opacity-25 transition ease-in-out duration-150">
                            Export as PDF
                        </button>
                    </div>

                    <div class="mt-4 text-gray-500">
                        @if ($products->isEmpty())
                            <p>No products currently low on stock.</p>
                        @else
                            <table class="table-auto w-full mt-4">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Product Name</th>
                                        <th class="px-4 py-2">SKU</th>
                                        <th class="px-4 py-2">Current Stock</th>
                                        <th class="px-4 py-2">Reorder Level</th>
                                        <th class="px-4 py-2">Category</th>
                                        <th class="px-4 py-2">Supplier</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $product->name }}</td>
                                            <td class="border px-4 py-2">{{ $product->sku }}</td>
                                            <td class="border px-4 py-2">{{ $product->current_stock }}</td>
                                            <td class="border px-4 py-2">{{ $product->reorder_level }}</td>
                                            <td class="border px-4 py-2">{{ $product->category->name }}</td>
                                            <td class="border px-4 py-2">{{ $product->supplier->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
