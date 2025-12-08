<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8"
     x-data="{
        viewMode: 'table',
        init() {
            const stored = localStorage.getItem('userManagementViewMode');
            if (stored) {
                this.viewMode = stored;
            }
        },
        toggleViewMode() {
            this.viewMode = this.viewMode === 'table' ? 'card' : 'table';
            localStorage.setItem('userManagementViewMode', this.viewMode);
        }
    }"
     x-cloak @init="init">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">User Management</h1>

        <!-- Search and Controls -->
        <div class="mb-6 flex flex-col md:flex-row justify-between items-stretch md:items-center gap-4">
            <div class="flex-1">
                <input
                    wire:model.live="search"
                    type="text"
                    placeholder="Search by userid, name, or email..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                >
            </div>
            <button @click="toggleViewMode" class="w-full md:w-auto px-4 py-2 bg-gray-600 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 text-white rounded-lg inline-flex items-center justify-center font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4H5a2 2 0 00-2 2v14a2 2 0 002 2h4m0-18v18m0-18l10-4v18l-10 4M19 5l-7 4m0 6l7-4"></path>
                </svg>
                {{ $viewMode === 'table' ? 'Card View' : 'Table View' }}
            </button>
            <button wire:click="openForm" class="w-full md:w-auto px-4 py-2 bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-lg font-medium">
                Add New User
            </button>
        </div>

        <!-- Form -->
        @if ($showForm)
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $editingUserId ? 'Edit User' : 'Create New User' }}</h2>
                </div>

                <div class="p-6">
                    <form wire:submit="save" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">User ID</label>
                                <input
                                    type="text"
                                    wire:model="userid"
                                    {{ $editingUserId ? 'disabled' : '' }}
                                    placeholder="Enter user ID"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                                >
                                @error('userid') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                                <input
                                    type="text"
                                    wire:model="name"
                                    placeholder="Enter full name"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                                >
                                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                <input
                                    type="email"
                                    wire:model="email"
                                    placeholder="Enter email address"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                                >
                                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                                <input
                                    type="password"
                                    wire:model="password"
                                    :placeholder="$editingUserId ? 'Leave blank to keep current' : 'Enter password'"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                                >
                                @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
                                <input
                                    type="password"
                                    wire:model="password_confirmation"
                                    placeholder="Confirm password"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                                >
                            </div>

                            <div class="flex items-center pt-6">
                                <label class="flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        wire:model="is_admin"
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded"
                                    >
                                    <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Admin User</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex space-x-4 mt-6">
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Save</button>
                            <button type="button" wire:click="closeForm" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Table View -->
        @if ($viewMode === 'table')
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">User ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Admin</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->userid }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_admin ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                            {{ $user->is_admin ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="edit({{ $user->id }})" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4">Edit</button>
                                        <button wire:click="delete({{ $user->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Card View -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($users as $user)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->userid }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->name }}</p>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-4 space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $user->email }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Admin:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_admin ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                        {{ $user->is_admin ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $user->id }})" class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-md font-medium text-sm hover:bg-blue-200 dark:hover:bg-blue-900/50 transition">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $user->id }})" onclick="return confirm('Are you sure?')" class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-md font-medium text-sm hover:bg-red-200 dark:hover:bg-red-900/50 transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 dark:text-gray-400">No users found</p>
                    </div>
                @endforelse
            </div>
        @endif

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
