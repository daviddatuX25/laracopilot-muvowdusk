@props([
    'tabs' => [],
    'active' => 0,
])

<div x-data="{ activeTab: {{ $active }} }" class="w-full">
    <!-- Tab Buttons -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <div class="flex space-x-8">
            @forelse($tabs as $index => $tab)
                <button
                    @click="activeTab = {{ $index }}"
                    :class="activeTab === {{ $index }} ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'border-b-2 border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300'"
                    class="px-1 py-4 font-medium text-sm transition"
                >
                    {{ $tab['label'] ?? $tab }}
                </button>
            @empty
                {{ $slot }}
            @endforelse
        </div>
    </div>

    <!-- Tab Content -->
    <div class="mt-4">
        @forelse($tabs as $index => $tab)
            <div
                x-show="activeTab === {{ $index }}"
                x-transition
                class="tab-content"
            >
                {!! $tab['content'] ?? '' !!}
            </div>
        @empty
            {{ $slot }}
        @endforelse
    </div>
</div>
