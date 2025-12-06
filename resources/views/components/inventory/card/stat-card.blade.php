@props([
    'title' => '',
    'value' => '',
    'icon' => '',
    'color' => 'blue',
    'subtitle' => '',
])

@php
    $colors = [
        'blue' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-l-blue-500', 'text' => 'text-blue-600 dark:text-blue-400', 'icon' => 'bg-blue-100 dark:bg-blue-900/50'],
        'green' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-l-green-500', 'text' => 'text-green-600 dark:text-green-400', 'icon' => 'bg-green-100 dark:bg-green-900/50'],
        'red' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-l-red-500', 'text' => 'text-red-600 dark:text-red-400', 'icon' => 'bg-red-100 dark:bg-red-900/50'],
        'yellow' => ['bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'border' => 'border-l-yellow-500', 'text' => 'text-yellow-600 dark:text-yellow-400', 'icon' => 'bg-yellow-100 dark:bg-yellow-900/50'],
        'purple' => ['bg' => 'bg-purple-50 dark:bg-purple-900/20', 'border' => 'border-l-purple-500', 'text' => 'text-purple-600 dark:text-purple-400', 'icon' => 'bg-purple-100 dark:bg-purple-900/50'],
        'indigo' => ['bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'border' => 'border-l-indigo-500', 'text' => 'text-indigo-600 dark:text-indigo-400', 'icon' => 'bg-indigo-100 dark:bg-indigo-900/50'],
    ];

    $colorClass = $colors[$color] ?? $colors['blue'];
@endphp

<div @class([
    'bg-white dark:bg-gray-800 rounded-lg shadow-md border-l-4 p-6',
    $colorClass['border'],
    $colorClass['bg'],
])>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            @if($title)
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
            @endif
            @if($value)
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $value }}</p>
            @endif
            @if($subtitle)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>

        @if($icon)
            <div @class([
                'p-3 rounded-lg',
                $colorClass['icon'],
            ])>
                <svg class="h-8 w-8 {{ $colorClass['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{ $slot }}
                </svg>
            </div>
        @endif
    </div>
</div>
