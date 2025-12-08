<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-violet-100 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Edit Category</h1>

                <form wire:submit.prevent="update" class="space-y-6">
                    <div>
                        <x-inventory.form.form-input
                            id="name"
                            name="name"
                            wire:model="name"
                            label="Category Name"
                            placeholder="Enter category name"
                        />
                        @error('name') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <x-inventory.form.form-textarea
                            id="description"
                            name="description"
                            wire:model="description"
                            label="Description"
                            placeholder="Enter category description (optional)"
                            rows="3"
                        />
                        @error('description') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('categories.index') }}">
                            <x-inventory.button.button variant="outline">Cancel</x-inventory.button.button>
                        </a>
                        <x-inventory.button.button variant="primary" type="submit">Update Category</x-inventory.button.button>
                    </div>
                </form>
            </x-inventory.card.card>
        </div>
    </div>
</div>
