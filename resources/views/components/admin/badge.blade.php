@props([
    'variant' => 'gray',
])

@php
    $variants = [
        'green' => 'bg-success/10 text-success',
        'red' => 'bg-danger/10 text-danger',
        'blue' => 'bg-info/10 text-info',
        'yellow' => 'bg-warning/10 text-warning',
        'gray' => 'bg-background text-text-secondary',
    ];
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $variants[$variant] ?? $variants['gray'] }}">
    {{ $slot }}
</span>
