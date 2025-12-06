@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'error' => '',
    'hint' => '',
    'withIcon' => false,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        @class([
            'w-full px-4 py-2 border rounded-lg transition',
            'bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500',
            'border-gray-300 dark:border-gray-600',
            'pl-10' => $withIcon,
            'focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400',
            'disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50',
            'border-red-500 dark:border-red-400' => $error,
        ])
        {{ $attributes }}
    />

    @if($error)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $error }}</p>
    @endif

    @if($hint)
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $hint }}</p>
    @endif
</div>
