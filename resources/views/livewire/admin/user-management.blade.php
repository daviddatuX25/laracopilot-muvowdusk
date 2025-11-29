<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">User Management</h1>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800">{{ session('message') }}</p>
            </div>
        @endif

        <div class="mb-6 flex justify-between items-center">
            <div class="flex-1 mr-4">
                <input
                    wire:model.live="search"
                    type="text"
                    placeholder="Search by userid, name, or email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <button
                wire:click="openForm"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
            >
                Add New User
            </button>
        </div>

        @if ($showForm)
            <div class="mb-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $editingUserId ? 'Edit User' : 'Create New User' }}</h2>

                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">User ID</label>
                            <input
                                wire:model="userid"
                                type="text"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('userid') border-red-500 @enderror"
                                {{ $editingUserId ? 'disabled' : '' }}
                            >
                            @error('userid') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input
                                wire:model="name"
                                type="text"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror"
                            >
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input
                                wire:model="email"
                                type="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('email') border-red-500 @enderror"
                            >
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input
                                wire:model="password"
                                type="password"
                                placeholder="{{ $editingUserId ? 'Leave blank to keep current' : 'Enter password' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('password') border-red-500 @enderror"
                            >
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input
                                wire:model="password_confirmation"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                            >
                        </div>
                        <div class="flex items-center">
                            <input
                                wire:model="is_admin"
                                type="checkbox"
                                id="is_admin"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="is_admin" class="ml-2 block text-sm text-gray-700">Admin User</label>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
                        >
                            Save
                        </button>
                        <button
                            type="button"
                            wire:click="closeForm"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->userid }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_admin ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->is_admin ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                                <button wire:click="delete({{ $user->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
