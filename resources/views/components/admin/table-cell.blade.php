@props([
    'class' => '',
])

<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white {{ $class }}">
    {{ $slot }}
</td>
