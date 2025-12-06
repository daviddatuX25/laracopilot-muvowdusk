@props([
    'title' => '',
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
        </div>
    @endif

    <div @class(['px-6 py-4' => $padding])>
        {{ $slot }}
    </div>
</div>
