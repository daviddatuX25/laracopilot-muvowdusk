@props([
    'type' => 'error',
])

@php
    $types = [
        'error' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-200 dark:border-red-800', 'text' => 'text-red-800 dark:text-red-200'],
        'warning' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'border' => 'border-yellow-200 dark:border-yellow-800', 'text' => 'text-yellow-800 dark:text-yellow-200'],
        'info' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-200 dark:border-blue-800', 'text' => 'text-blue-800 dark:text-blue-200'],
    ];

    $style = $types[$type] ?? $types['error'];
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
