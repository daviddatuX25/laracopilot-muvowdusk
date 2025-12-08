@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'icon' => '',
])

@php
    $baseClasses = 'font-semibold rounded-lg transition duration-150 inline-flex items-center justify-center cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variants = [
        'primary' => 'bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 border-2 border-blue-200/50 dark:border-blue-800/50 hover:bg-blue-100/40 dark:hover:bg-blue-900/30 focus:ring-blue-400 disabled:opacity-50 backdrop-blur-sm',
        'secondary' => 'bg-gray-200/30 dark:bg-gray-800/20 text-gray-900 dark:text-white border-2 border-gray-300/50 dark:border-gray-700/50 hover:bg-gray-300/40 dark:hover:bg-gray-700/30 focus:ring-gray-500 disabled:opacity-50 backdrop-blur-sm',
        'danger' => 'bg-red-50/30 dark:bg-red-950/20 text-red-700 dark:text-red-300 border-2 border-red-200/50 dark:border-red-800/50 hover:bg-red-100/40 dark:hover:bg-red-900/30 focus:ring-red-400 disabled:opacity-50 backdrop-blur-sm',
        'success' => 'bg-green-50/30 dark:bg-green-950/20 text-green-700 dark:text-green-300 border-2 border-green-200/50 dark:border-green-800/50 hover:bg-green-100/40 dark:hover:bg-green-900/30 focus:ring-green-400 disabled:opacity-50 backdrop-blur-sm',
        'ghost' => 'text-blue-700 dark:text-blue-300 hover:bg-blue-50/20 dark:hover:bg-blue-950/20 focus:ring-blue-400 disabled:opacity-50 backdrop-blur-sm',
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
