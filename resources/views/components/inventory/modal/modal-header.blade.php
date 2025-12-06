@props([
    'title' => '',
    'closeButton' => true,
])

<div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
    @if($title)
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
    @endif

    @if($closeButton)
        <button
            @click="open = false"
            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition"
        >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>

<div class="px-6 py-4">
    {{ $slot }}
</div>
