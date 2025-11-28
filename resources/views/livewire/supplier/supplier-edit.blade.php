<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-800">Edit Supplier</h1>

                    <form wire:submit.prevent="update" class="mt-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                                <div class="mt-1">
                                    <input type="text" id="name" wire:model="name" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="contact_person" class="block text-sm font-medium text-gray-700">Contact Person (optional)</label>
                                <div class="mt-1">
                                    <input type="text" id="contact_person" wire:model="contact_person" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('contact_person') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email (optional)</label>
                                <div class="mt-1">
                                    <input type="email" id="email" wire:model="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('email') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone (optional)</label>
                                <div class="mt-1">
                                    <input type="text" id="phone" wire:model="phone" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                @error('phone') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address (optional)</label>
                            <div class="mt-1">
                                <textarea id="address" wire:model="address" rows="3" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                            @error('address') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('suppliers.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
