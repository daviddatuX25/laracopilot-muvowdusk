@props([
    'title' => '',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
@endphp

<div
    x-data="{ open: false }"
    class="relative"
>
    <!-- Modal Overlay -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0"
        x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0"
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-40"
        @click.self="open = false"
        style="display: none;"
    ></div>

    <!-- Modal Content -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div @class([
            'bg-white dark:bg-gray-800 rounded-lg shadow-xl',
            $sizes[$size] ?? $sizes['md'],
        ])>
            {{ $slot }}
        </div>
    </div>
</div>
