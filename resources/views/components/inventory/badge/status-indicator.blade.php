@props([
    'status' => 'active',
])

@php
    $statusClasses = [
        'active' => 'bg-green-500 dark:bg-green-600',
        'idle' => 'bg-yellow-500 dark:bg-yellow-600',
        'offline' => 'bg-gray-500 dark:bg-gray-600',
        'warning' => 'bg-orange-500 dark:bg-orange-600',
    ];
@endphp

<span class="inline-block relative">
    <span @class([
        'inline-block h-3 w-3 rounded-full shadow-lg',
        $statusClasses[$status] ?? $statusClasses['active'],
        'animate-pulse' => in_array($status, ['active', 'warning']),
    ])></span>
</span>
