@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
])

@php
    $baseClasses = 'font-semibold rounded-lg transition duration-150 inline-flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2';

    $variants = [
        'primary' => 'bg-blue-50/30 dark:bg-blue-950/20 text-blue-700 dark:text-blue-300 border-2 border-blue-200/50 dark:border-blue-800/50 hover:bg-blue-100/40 dark:hover:bg-blue-900/30 hover:border-blue-300/70 dark:hover:border-blue-700/70 focus:ring-blue-400 disabled:opacity-50 backdrop-blur-sm',
        'secondary' => 'bg-gray-200/30 dark:bg-gray-800/20 text-gray-900 dark:text-white border-2 border-gray-300/50 dark:border-gray-700/50 hover:bg-gray-300/40 dark:hover:bg-gray-700/30 focus:ring-gray-500 disabled:opacity-50 backdrop-blur-sm',
        'success' => 'bg-green-50/30 dark:bg-green-950/20 text-green-700 dark:text-green-300 border-2 border-green-200/50 dark:border-green-800/50 hover:bg-green-100/40 dark:hover:bg-green-900/30 hover:border-green-300/70 dark:hover:border-green-700/70 focus:ring-green-400 disabled:opacity-50 backdrop-blur-sm',
        'danger' => 'bg-red-50/30 dark:bg-red-950/20 text-red-700 dark:text-red-300 border-2 border-red-200/50 dark:border-red-800/50 hover:bg-red-100/40 dark:hover:bg-red-900/30 hover:border-red-300/70 dark:hover:border-red-700/70 focus:ring-red-400 disabled:opacity-50 backdrop-blur-sm',
        'warning' => 'bg-yellow-50/30 dark:bg-yellow-950/20 text-yellow-700 dark:text-yellow-300 border-2 border-yellow-200/50 dark:border-yellow-800/50 hover:bg-yellow-100/40 dark:hover:bg-yellow-900/30 hover:border-yellow-300/70 dark:hover:border-yellow-700/70 focus:ring-yellow-400 disabled:opacity-50 backdrop-blur-sm',
        'info' => 'bg-indigo-50/30 dark:bg-indigo-950/20 text-indigo-700 dark:text-indigo-300 border-2 border-indigo-200/50 dark:border-indigo-800/50 hover:bg-indigo-100/40 dark:hover:bg-indigo-900/30 hover:border-indigo-300/70 dark:hover:border-indigo-700/70 focus:ring-indigo-400 disabled:opacity-50 backdrop-blur-sm',
        'violet' => 'bg-violet-50/30 dark:bg-violet-950/20 text-violet-700 dark:text-violet-300 border-2 border-violet-200/50 dark:border-violet-800/50 hover:bg-violet-100/40 dark:hover:bg-violet-900/30 hover:border-violet-300/70 dark:hover:border-violet-700/70 focus:ring-violet-400 disabled:opacity-50 backdrop-blur-sm',
        'outline' => 'border-2 border-blue-300/60 dark:border-blue-700/60 text-blue-700 dark:text-blue-300 hover:bg-blue-50/20 dark:hover:bg-blue-950/20 focus:ring-blue-400 disabled:opacity-50 backdrop-blur-sm',
        'violet-outline' => 'border-2 border-violet-300/60 dark:border-violet-700/60 text-violet-700 dark:text-violet-300 hover:bg-violet-50/20 dark:hover:bg-violet-950/20 focus:ring-violet-400 disabled:opacity-50 backdrop-blur-sm',
        'ghost' => 'text-blue-700 dark:text-blue-300 hover:bg-blue-50/20 dark:hover:bg-blue-950/20 focus:ring-blue-400 disabled:opacity-50 backdrop-blur-sm',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
        'xl' => 'px-8 py-4 text-xl',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    @class([
        $baseClasses,
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
        'opacity-50 cursor-not-allowed' => $disabled || $loading,
    ])
    {{ $attributes }}
>
    @if($loading)
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    {{ $slot }}
</button>
