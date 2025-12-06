@props([
    'columns' => [],
])

<thead class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <tr>
        @if(!empty($columns))
            @foreach($columns as $column)
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                    {{ $column }}
                </th>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </tr>
</thead>
