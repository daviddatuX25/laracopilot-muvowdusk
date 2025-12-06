@props([
    'type' => 'success',
])

@php
    $types = [
        'success' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-200 dark:border-green-800', 'text' => 'text-green-800 dark:text-green-200'],
        'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800', 'text' => 'text-blue-800 dark:text-blue-200'],
    ];

    $style = $types[$type] ?? $types['success'];
@endphp

<div @class([
    'rounded-lg border p-4',
    $style['bg'],
    $style['border'],
])>
    <p @class([
        'text-sm',
        $style['text'],
    ])>
        {{ $slot }}
    </p>
</div>
