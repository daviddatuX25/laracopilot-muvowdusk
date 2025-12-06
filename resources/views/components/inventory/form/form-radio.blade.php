@props([
    'name' => '',
    'label' => '',
    'options' => [],
    'selected' => '',
    'disabled' => false,
    'error' => '',
])

<fieldset class="mb-4">
    @if($label)
        <legend class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
            {{ $label }}
        </legend>
    @endif

    <div class="space-y-2">
        @foreach($options as $value => $optionLabel)
            <div class="flex items-center">
                <input
                    type="radio"
                    id="{{ $name }}_{{ $value }}"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    {{ $value === $selected ? 'checked' : '' }}
                    {{ $disabled ? 'disabled' : '' }}
                    @class([
                        'h-4 w-4 border-gray-300 dark:border-gray-600 text-blue-600 dark:text-blue-400',
                        'focus:ring-2 focus:ring-blue-500 focus:ring-offset-0',
                        'disabled:opacity-50 disabled:cursor-not-allowed',
                    ])
                    {{ $attributes }}
                />
                <label for="{{ $name }}_{{ $value }}" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                    {{ $optionLabel }}
                </label>
            </div>
        @endforeach
    </div>

    @if($error)
        <p class="mt-2 text-sm text-red-500 dark:text-red-400">{{ $error }}</p>
    @endif
</fieldset>
