@props([
    'type' => 'success',
])

@php
    $types = [
        'success' => 'bg-success/10 border-success text-success',
        'error' => 'bg-danger/10 border-danger text-danger',
        'warning' => 'bg-warning/10 border-warning text-warning',
        'info' => 'bg-info/10 border-info text-info',
    ];
@endphp

<div class="mb-4 p-4 border rounded-lg {{ $types[$type] ?? $types['success'] }}">
    <p>
        {{ $slot }}
    </p>
</div>
