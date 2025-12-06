@props([
    'align' => 'right',
])

<div @class([
    'px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 flex gap-3',
    'justify-end' => $align === 'right',
    'justify-start' => $align === 'left',
    'justify-center' => $align === 'center',
    'justify-between' => $align === 'between',
])>
    {{ $slot }}
</div>
