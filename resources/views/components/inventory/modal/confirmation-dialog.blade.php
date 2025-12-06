@props([
    'title' => 'Confirm Action',
    'message' => 'Are you sure?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'variant' => 'danger',
])

<div
    x-data="{ open: false }"
    class="relative"
>
    <!-- Overlay -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black/50 dark:bg-black/70 z-40"
        @click.self="open = false"
        style="display: none;"
    ></div>

    <!-- Dialog -->
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display: none;"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-sm w-full">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
            </div>

            <!-- Body -->
            <div class="px-6 py-4">
                <p class="text-gray-600 dark:text-gray-400">{{ $message }}</p>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex gap-2 justify-end">
                <button
                    @click="open = false"
                    class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition"
                >
                    {{ $cancelText }}
                </button>
                <button
                    @click="open = false; $dispatch('confirmed')"
                    @class([
                        'px-4 py-2 text-white rounded-lg transition',
                        'bg-red-600 hover:bg-red-700' => $variant === 'danger',
                        'bg-yellow-600 hover:bg-yellow-700' => $variant === 'warning',
                        'bg-blue-600 hover:bg-blue-700' => $variant === 'primary',
                    ])
                >
                    {{ $confirmText }}
                </button>
            </div>
        </div>
    </div>
</div>
