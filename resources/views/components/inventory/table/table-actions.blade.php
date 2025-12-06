@props([
    'align' => 'start',
])

<x-inventory.table.table-cell :align="$align">
    <div class="flex gap-3 justify-{{ $align === 'right' ? 'end' : ($align === 'center' ? 'center' : 'start') }}">
        {{ $slot }}
    </div>
</x-inventory.table.table-cell>
