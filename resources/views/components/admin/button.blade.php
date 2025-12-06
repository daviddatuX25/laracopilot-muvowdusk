@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
])

@php
    $baseClasses = 'font-bold rounded-lg transition cursor-pointer hover:opacity-90';

    $variants = [
        'primary' => 'bg-primary text-white',
        'secondary' => 'bg-background text-text border border-border',
        'success' => 'bg-success text-white',
        'danger' => 'bg-danger text-white',
    ];

    $sizes = [
        'sm' => 'py-1 px-2 text-sm',
        'md' => 'py-2 px-4',
        'lg' => 'py-3 px-6 text-lg',
    ];
@endphp

<button
    {{ $attributes->merge([
        'type' => $type,
        'class' => $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']),
    ]) }}
>
    {{ $slot }}
</button>
