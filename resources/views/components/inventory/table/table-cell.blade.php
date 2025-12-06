@props([
    'align' => 'left',
])

<td @class([
    'px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100',
    'text-left' => $align === 'left',
    'text-center' => $align === 'center',
    'text-right' => $align === 'right',
])>
    {{ $slot }}
</td>
