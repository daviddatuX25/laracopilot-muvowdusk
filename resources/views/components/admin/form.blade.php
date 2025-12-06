@props([
    'title' => 'Create Item',
    'showForm' => false,
])

<div class="mb-6 bg-surface rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">{{ $title }}</h2>

    <form wire:submit="save" class="space-y-4">
        {{ $slot }}
    </form>
</div>
