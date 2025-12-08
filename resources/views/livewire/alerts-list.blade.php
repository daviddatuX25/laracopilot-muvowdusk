<div wire:poll-10000ms="refreshAlerts"
     x-data="{
        viewMode: 'table',
        init() {
            const stored = localStorage.getItem('alertsListViewMode');
            if (stored) {
                this.viewMode = stored;
            }
        },
        toggleViewMode() {
            this.viewMode = this.viewMode === 'table' ? 'card' : 'table';
            localStorage.setItem('alertsListViewMode', this.viewMode);
        }
    }"
     x-cloak @init="init">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-violet-100 leading-tight">
            {{ __('Alerts') }}
            @if($totalPending > 0)
                <span class="inline-flex items-center justify-center px-3 py-1 ml-2 text-sm font-medium text-white bg-red-600 dark:bg-red-700 rounded-full animate-pulse">
                    {{ $totalPending }}
                </span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Pending Alerts</h1>
                            <div class="flex items-center gap-2">
                                <div class="relative inline-flex items-center">
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500 animate-pulse"></span>
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Live</span>
                            </div>
                        </div>
                        <button @click="toggleViewMode" class="inline-flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4H5a2 2 0 00-2 2v14a2 2 0 002 2h4m0-18v18m0-18l10-4v18l-10 4M19 5l-7 4m0 6l7-4"/>
                            </svg>
                            {{ $viewMode === 'table' ? 'Card View' : 'Table View' }}
                        </button>
                    </div>

                    <div class="mt-6 text-gray-500 dark:text-gray-400">
                        @if ($alerts->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12">
                                <svg class="w-16 h-16 text-green-400 dark:text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-xl text-gray-600 dark:text-gray-300 font-semibold">No Pending Alerts</p>
                                <p class="text-gray-500 dark:text-gray-400 mt-2">All systems are running smoothly!</p>
                            </div>
                        @else
                            <div x-show="viewMode === 'table'" x-cloak>
                                <div class="overflow-x-auto">
                                    <x-inventory.table.table>
                                        <x-inventory.table.table-header :columns="['Status', 'Product', 'Type', 'Message', 'Age', 'Actions']" />
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($alerts as $alert)
                                                <x-inventory.table.table-row>
                                                    <x-inventory.table.table-cell>
                                                        @if (!$alert->isSeen())
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-3 h-3 bg-red-600 dark:bg-red-400 rounded-full animate-pulse"></div>
                                                                <span class="text-xs font-semibold text-red-700 dark:text-red-300">UNSEEN</span>
                                                            </div>
                                                        @else
                                                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">SEEN</span>
                                                        @endif
                                                    </x-inventory.table.table-cell>
                                                    <x-inventory.table.table-cell>
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $alert->product->name }}</div>
                                                    </x-inventory.table.table-cell>
                                                    <x-inventory.table.table-cell>
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $alert->type === 'low_stock' ? 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300' }}">
                                                            @if($alert->type === 'low_stock')
                                                                ⚠️ Low Stock
                                                            @else
                                                                🔴 Out of Stock
                                                            @endif
                                                        </span>
                                                    </x-inventory.table.table-cell>
                                                    <x-inventory.table.table-cell>
                                                        <div class="text-sm text-gray-900 dark:text-gray-200">{{ $alert->message }}</div>
                                                    </x-inventory.table.table-cell>
                                                    <x-inventory.table.table-cell>
                                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                                            {{ $alert->getFormattedAge() }}
                                                        </div>
                                                    </x-inventory.table.table-cell>
                                                    <x-inventory.table.table-actions>
                                                        @if (!$alert->isSeen())
                                                            <button wire:click="markAsSeen({{ $alert->id }})"
                                                                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 text-sm font-medium">
                                                                👁️ Seen
                                                            </button>
                                                        @endif
                                                        <button wire:click="resolveAlert({{ $alert->id }})"
                                                                wire:confirm="Are you sure you want to resolve this alert?"
                                                                class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 text-sm font-medium">
                                                            ✓ Resolve
                                                        </button>
                                                    </x-inventory.table.table-actions>
                                                </x-inventory.table.table-row>
                                            @endforeach
                                        </tbody>
                                    </x-inventory.table.table>
                                </div>
                            </div>

                            <!-- Card View -->
                            <div x-show="viewMode === 'card'" x-cloak>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($alerts as $alert)
                                        <x-inventory.card.card>
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center gap-3">
                                                    @if (!$alert->isSeen())
                                                        <div class="flex flex-col items-start">
                                                            <div class="w-3 h-3 bg-red-600 dark:bg-red-400 rounded-full animate-pulse mb-2"></div>
                                                            <span class="text-xs font-semibold text-red-700 dark:text-red-300">UNSEEN</span>
                                                        </div>
                                                    @else
                                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">SEEN</span>
                                                    @endif
                                                </div>
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $alert->type === 'low_stock' ? 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-300' : 'bg-red-100 dark:bg-red-900/40 text-red-800 dark:text-red-300' }}">
                                                    @if($alert->type === 'low_stock')
                                                        ⚠️ Low Stock
                                                    @else
                                                        🔴 Out of Stock
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="mb-4">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $alert->product->name }}</h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $alert->message }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500">{{ $alert->getFormattedAge() }}</p>
                                            </div>

                                            <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                @if (!$alert->isSeen())
                                                    <button wire:click="markAsSeen({{ $alert->id }})"
                                                            class="flex-1 px-3 py-2 rounded-md text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition text-sm font-medium">
                                                        👁️ Seen
                                                    </button>
                                                @endif
                                                <button wire:click="resolveAlert({{ $alert->id }})"
                                                        wire:confirm="Are you sure you want to resolve this alert?"
                                                        class="flex-1 px-3 py-2 rounded-md text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 transition text-sm font-medium">
                                                    ✓ Resolve
                                                </button>
                                            </div>
                                        </x-inventory.card.card>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4">
                                {{ $alerts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
