@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'icon' => '',
])

@php
    $baseClasses = 'font-semibold rounded-lg transition duration-150 inline-flex items-center justify-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 disabled:bg-blue-400',
        'secondary' => 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 focus:ring-gray-500 disabled:bg-gray-100',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 disabled:bg-red-400',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 disabled:bg-green-400',
        'ghost' => 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:ring-gray-500',
    ];

    $sizes = [
        'sm' => 'p-1.5',
        'md' => 'p-2',
        'lg' => 'p-3',
    ];
@endphp

<button
    type="button"
    {{ $disabled ? 'disabled' : '' }}
    @class([
        $baseClasses,
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
        'opacity-50 cursor-not-allowed' => $disabled,
    ])
    {{ $attributes }}
>
    @if($icon)
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            {{-- Icon will be passed as slot or icon name --}}
        </svg>
    @endif
    {{ $slot }}
</button>
