@props([
    'striped' => true,
])

<div class="overflow-x-auto scrollbar-hide rounded-lg border border-gray-200 dark:border-gray-700">
    <table @class([
        'w-full divide-y divide-gray-200 dark:divide-gray-700',
        'bg-white dark:bg-gray-800',
    ])>
        {{ $slot }}
    </table>
</div>
