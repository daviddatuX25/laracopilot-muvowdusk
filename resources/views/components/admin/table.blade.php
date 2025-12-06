@props([
    'headers' => [],
    'rows' => [],
    'actions' => [],
])

<div class="bg-surface rounded-lg shadow overflow-x-auto scrollbar-hide">
    <table class="min-w-full divide-y divide-border">
        <thead class="bg-header-bg">
            <tr>
                @foreach ($headers as $header)
                    <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
                @if (count($actions) > 0)
                    <th class="px-6 py-3 text-left text-xs font-medium text-text-secondary uppercase tracking-wider">
                        Actions
                    </th>
                @endif
            </tr>
        </thead>
        <tbody class="bg-surface divide-y divide-border">
            {{ $slot }}
        </tbody>
    </table>
</div>
