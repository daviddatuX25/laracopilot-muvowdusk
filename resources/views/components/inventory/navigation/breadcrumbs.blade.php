@props([
    'links' => [],
    'separator' => '/',
])

<nav aria-label="Breadcrumb" class="mb-4">
    <ol class="flex items-center space-x-2 text-sm">
        @forelse($links as $link)
            @if($loop->last)
                <li class="text-gray-900 dark:text-white font-medium">{{ $link['label'] ?? $link }}</li>
            @else
                <li>
                    <a href="{{ $link['url'] ?? '#' }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">
                        {{ $link['label'] ?? $link }}
                    </a>
                </li>
                <li class="text-gray-400 dark:text-gray-600">{{ $separator }}</li>
            @endif
        @empty
            {{ $slot }}
        @endforelse
    </ol>
</nav>
