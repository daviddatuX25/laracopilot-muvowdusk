@props([
    'status' => 'in_stock',
    'quantity' => 0,
])

@php
    $statusMap = [
        'in_stock' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-800 dark:text-green-300', 'label' => 'In Stock'],
        'low_stock' => ['bg' => 'bg-yellow-100 dark:bg-yellow-900/30', 'text' => 'text-yellow-800 dark:text-yellow-300', 'label' => 'Low Stock'],
        'out_of_stock' => ['bg' => 'bg-red-100 dark:bg-red-900/30', 'text' => 'text-red-800 dark:text-red-300', 'label' => 'Out of Stock'],
    ];

    $current = $statusMap[$status] ?? $statusMap['in_stock'];
@endphp

<span @class([
    'inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold',
    $current['bg'],
    $current['text'],
])>
    <span class="inline-block w-2 h-2 rounded-full" @class([
        'bg-green-600' => $status === 'in_stock',
        'bg-yellow-600' => $status === 'low_stock',
        'bg-red-600' => $status === 'out_of_stock',
    ])></span>
    {{ $current['label'] }}
    @if($quantity)
        <span class="opacity-75">({{ $quantity }})</span>
    @endif
</span>
