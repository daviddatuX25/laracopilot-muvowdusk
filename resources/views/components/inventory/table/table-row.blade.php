@props([
    'hover' => true,
])

<tr @class([
    'border-b border-gray-200 dark:border-gray-700',
    'hover:bg-gray-50 dark:hover:bg-gray-700/50 transition' => $hover,
])>
    {{ $slot }}
</tr>
