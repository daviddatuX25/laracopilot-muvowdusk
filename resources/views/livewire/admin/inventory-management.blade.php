<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Inventory Management</h1>

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
                    placeholder="Search by name or location..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <button
                wire:click="openForm"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg"
            >
                Add New Inventory
            </button>
        </div>

        @if ($showForm)
            <div class="mb-6 bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $editingInventoryId ? 'Edit Inventory' : 'Create New Inventory' }}</h2>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Inventory Name</label>
                        <input
                            wire:model="name"
                            type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror"
                            placeholder="e.g., Main Warehouse"
                        >
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input
                            wire:model="location"
                            type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('location') border-red-500 @enderror"
                            placeholder="e.g., Building A, Floor 2"
                        >
                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea
                            wire:model="description"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('description') border-red-500 @enderror"
                            placeholder="Enter inventory description..."
                        ></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select
                            wire:model="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('status') border-red-500 @enderror"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($inventories as $inventory)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $inventory->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $inventory->location ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($inventory->description, 50) ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($inventory->status === 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.view-inventory', $inventory->id) }}" class="text-green-600 hover:text-green-900 mr-4">View</a>
                                <button wire:click="edit({{ $inventory->id }})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                                <button wire:click="delete({{ $inventory->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No inventories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $inventories->links() }}
        </div>
    </div>
</div>
