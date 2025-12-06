@props([
    'label' => '',
])

<div class="flex items-center">
    <input
        {{ $attributes->merge([
            'type' => 'checkbox',
            'class' => 'h-4 w-4 border-border rounded accent-primary',
        ]) }}
    >
    @if ($label)
        <label class="ml-2 block text-sm text-gray-900 dark:text-white">
            {{ $label }}
        </label>
    @endif
</div>
