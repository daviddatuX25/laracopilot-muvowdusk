<div x-data="{
    viewMode: 'table',
    init() {
        const stored = localStorage.getItem('supplierListViewMode');
        if (stored) {
            this.viewMode = stored;
        }
    },
    toggleViewMode() {
        this.viewMode = this.viewMode === 'table' ? 'card' : 'table';
        localStorage.setItem('supplierListViewMode', this.viewMode);
    }
}" x-cloak @init="init">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Suppliers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card>
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Supplier List</h1>
                    <div class="flex gap-3">
                        <x-inventory.button.button
                            variant="violet-outline"
                            size="sm"
                            @click="toggleViewMode"
                        >
                            <svg x-show="viewMode === 'table'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2h-6a2 2 0 01-2-2V4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h6m-6 4h6"/>
                            </svg>
                            <svg x-show="viewMode === 'card'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16"/>
                            </svg>
                            <span x-text="viewMode === 'table' ? 'Card View' : 'Table View'"></span>
                        </x-inventory.button.button>
                        <a href="{{ route('suppliers.create') }}">
                            <x-inventory.button.button variant="violet" size="sm">
                                Add New Supplier
                            </x-inventory.button.button>
                        </a>
                    </div>
                </div>

                @if (session()->has('message'))
                    <x-inventory.state.success-message>{{ session('message') }}</x-inventory.state.success-message>
                @endif

                <div class="mt-6">
                    <!-- Search Bar -->
                    <x-inventory.form.form-input-with-icon
                        name="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search suppliers by name, contact, email, or phone..."
                        icon="search"
                    />

                    @if ($suppliers->isEmpty())
                        <x-inventory.state.empty-state title="No suppliers found" message="Create your first supplier to get started." />
                    @else
                        <!-- Table view -->
                        <div x-show="viewMode === 'table'" x-cloak>
                            <x-inventory.table.table>
                                <x-inventory.table.table-header :columns="['Name', 'Contact', 'Actions']" />

                                @foreach ($suppliers as $supplier)
                                    <x-inventory.table.table-row>
                                        <x-inventory.table.table-cell>{{ $supplier->name }}</x-inventory.table.table-cell>
                                        <x-inventory.table.table-cell>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $supplier->contact_person }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $supplier->email }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $supplier->phone }}</div>
                                        </x-inventory.table.table-cell>
                                        <x-inventory.table.table-actions>
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="text-violet-600 dark:text-violet-400 hover:text-violet-900 dark:hover:text-violet-300 text-sm font-medium">Edit</a>
                                            <button wire:click="delete({{ $supplier->id }})"
                                                    wire:confirm="Are you sure?"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 text-sm font-medium">Delete</button>
                                        </x-inventory.table.table-actions>
                                    </x-inventory.table.table-row>
                                @endforeach
                            </x-inventory.table.table>
                        </div>

                        <!-- Card view -->
                        <div x-show="viewMode === 'card'" x-cloak>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($suppliers as $supplier)
                                    <x-inventory.card.card class="border-l-">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ $supplier->name }}</h3>

                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 space-y-2 mb-4">
                                            <div class="flex items-center text-sm">
                                                <span class="font-medium text-gray-700 dark:text-gray-300 w-24">Contact:</span>
                                                <span class="text-gray-600 dark:text-gray-400">{{ $supplier->contact_person }}</span>
                                            </div>
                                            <div class="flex items-start text-sm">
                                                <span class="font-medium text-gray-700 dark:text-gray-300 w-24 pt-1">Email:</span>
                                                <span class="text-gray-600 dark:text-gray-400 break-all">{{ $supplier->email }}</span>
                                            </div>
                                            <div class="flex items-center text-sm">
                                                <span class="font-medium text-gray-700 dark:text-gray-300 w-24">Phone:</span>
                                                <span class="text-gray-600 dark:text-gray-400">{{ $supplier->phone }}</span>
                                            </div>
                                        </div>

                                        <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="flex-1">
                                                <x-inventory.button.button variant="info" size="sm" class="w-full">Edit</x-inventory.button.button>
                                            </a>
                                            <button wire:click="delete({{ $supplier->id }})"
                                                    wire:confirm="Are you sure?"
                                                    class="flex-1">
                                                <x-inventory.button.button variant="danger" size="sm" class="w-full">Delete</x-inventory.button.button>
                                            </button>
                                        </div>
                                    </x-inventory.card.card>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6">
                            {{ $suppliers->links() }}
                        </div>
                    @endif
                </div>
            </x-inventory.card.card>
        </div>
    </div>
</div>
