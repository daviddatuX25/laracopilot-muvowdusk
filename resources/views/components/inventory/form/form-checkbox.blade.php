@props([
    'name' => '',
    'label' => '',
    'checked' => false,
    'disabled' => false,
    'error' => '',
])

<div class="mb-4 flex items-center">
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="1"
        {{ $checked ? 'checked' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        @class([
            'h-4 w-4 border rounded transition cursor-pointer',
            'bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400',
            'border-gray-300 dark:border-gray-600',
            'focus:ring-2 focus:ring-blue-500 focus:ring-offset-0',
            'disabled:opacity-50 disabled:cursor-not-allowed',
            'border-red-500 dark:border-red-400' => $error,
        ])
        {{ $attributes }}
    />

    @if($label)
        <label for="{{ $name }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
            {{ $label }}
        </label>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400 w-full">{{ $error }}</p>
    @endif
</div>
