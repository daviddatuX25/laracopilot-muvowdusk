@props([
    'colspan' => 5,
    'message' => 'No items found',
])

<tr>
    <td colspan="{{ $colspan }}" class="px-6 py-4 text-center text-text-secondary">
        {{ $message }}
    </td>
</tr>
