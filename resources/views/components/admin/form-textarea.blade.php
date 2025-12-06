@props([
    'label' => '',
    'rows' => 4,
    'placeholder' => '',
    'error' => '',
    'wire' => '',
])

<div>
    @if ($label)
        <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif
    <textarea
        {{ $attributes->merge([
            'rows' => $rows,
            'placeholder' => $placeholder,
            'class' => 'w-full px-4 py-2 border border-border rounded-lg bg-input-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent ' . ($error ? 'border-red-500' : ''),
        ]) }}
        @if ($wire) wire:model="{{ $wire }}" @endif
    ></textarea>
    @if ($error)
        <span class="text-sm text-danger">{{ $error }}</span>
    @endif
</div>
