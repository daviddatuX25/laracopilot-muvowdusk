@props([
    'emptyMessage' => 'No items found',
])

<tr class="hover:bg-surface-hover">
    {{ $slot }}
</tr>
