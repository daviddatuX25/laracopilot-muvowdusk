@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Record Stock Movement</h1>

        <form action="{{ route('stock-movements.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                    <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" data-reorder-level="{{ $product->reorder_level }}">
                                {{ $product->name }} (Stock: {{ $product->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Movement Type</label>
                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Select a type</option>
                        <option value="in">Stock In</option>
                        <option value="out">Stock Out</option>
                        <option value="adjustment">Stock Adjustment</option>
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                </div>

                <div class="md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700">Reason (Required for negative adjustments)</label>
                    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
                    Record Movement
                </button>
                <a href="{{ route('stock-movements.index') }}" class="ml-3 text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const typeSelect = document.getElementById('type');
        const quantityInput = document.getElementById('quantity');
        const reasonTextarea = document.getElementById('reason');

        // Show/hide reason field based on type and quantity
        function toggleReasonField() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const currentStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const type = typeSelect.value;
            const quantity = parseInt(quantityInput.value) || 0;

            if (type === 'adjustment' && (currentStock + quantity) < 0) {
                reasonTextarea.required = true;
                reasonTextarea.closest('div').classList.add('required');
            } else {
                reasonTextarea.required = false;
                reasonTextarea.closest('div').classList.remove('required');
            }
        }

        productSelect.addEventListener('change', toggleReasonField);
        typeSelect.addEventListener('change', toggleReasonField);
        quantityInput.addEventListener('input', toggleReasonField);
    });
</script>
@endpush
@endsection