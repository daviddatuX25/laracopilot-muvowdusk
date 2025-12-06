@props([
    'variant' => 'blue',
])

@php
    $variants = [
        'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
        'green' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
        'red' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
        'yellow' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
        'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300',
        'indigo' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300',
        'gray' => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300',
    ];
@endphp

<span @class([
    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
    $variants[$variant] ?? $variants['blue'],
])>
    {{ $slot }}
</span>
