@props([
    'type' => 'info',
    'dismissible' => true,
])

@php
    $types = [
        'success' => ['bg' => 'bg-green-100 border-green-400 text-green-700', 'icon' => '✓'],
        'error' => ['bg' => 'bg-red-100 border-red-400 text-red-700', 'icon' => '✕'],
        'warning' => ['bg' => 'bg-yellow-100 border-yellow-400 text-yellow-700', 'icon' => '⚠'],
        'info' => ['bg' => 'bg-blue-100 border-blue-400 text-blue-700', 'icon' => 'ℹ'],
    ];

    $style = $types[$type] ?? $types['info'];
@endphp

<div @class([
    'fixed top-4 right-4 z-50 border rounded shadow-lg p-4 flex items-center gap-2 animate-fade-in',
    $style['bg'],
])
    x-data="{ show: true }"
    x-show="show"
    @click.away="show = false"
>
    <span>{{ $style['icon'] }}</span>
    <span class="text-sm font-medium">{{ $slot }}</span>
    @if($dismissible)
        <button @click="show = false" class="ml-auto text-gray-600 hover:text-gray-900">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
</style>
