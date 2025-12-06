<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">User-Inventory Links</h1>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                <p class="text-green-800 dark:text-green-300">{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                <p class="text-red-800 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Users List -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Select User</h2>
                </div>

                <div class="p-4">
                    <input
                        wire:model.live="search"
                        type="text"
                        placeholder="Search users..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg mb-4 focus:ring-2 focus:ring-blue-500"
                    >

                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse ($users as $user)
                            <button
                                wire:click="selectUser({{ $user->id }})"
                                class="w-full text-left px-4 py-3 rounded-lg border-2 transition {{ $selectedUserId === $user->id ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500' }}"
                            >
                                <div class="font-medium text-gray-900 dark:text-white">{{ $user->userid }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->name }}</div>
                            </button>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">No users found</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <!-- Inventories Selection -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        Assign Inventories
                        @if ($selectedUserId)
                            <span class="text-sm text-gray-600 dark:text-gray-400">({{ count($selectedInventoryIds) }} selected)</span>
                        @endif
                    </h2>
                </div>

                <div class="p-4">
                    @if ($selectedUserId)
                        <input
                            wire:model.live="inventorySearch"
                            type="text"
                            placeholder="Search inventories..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg mb-4 focus:ring-2 focus:ring-blue-500"
                        >

                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse ($inventories as $inventory)
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        wire:click="toggleInventory({{ $inventory->id }})"
                                        {{ in_array($inventory->id, $selectedInventoryIds) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
                                    >
                                    <div class="ml-3">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $inventory->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $inventory->location ?? 'No location' }}</div>
                                    </div>
                                </label>
                            @empty
                                <p class="text-center text-gray-500 dark:text-gray-400 py-4">No inventories available</p>
                            @endforelse
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <button
                                wire:click="saveLinks"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
                            >
                                Save Links
                            </button>
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">Select a user to assign inventories</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
