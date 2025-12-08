<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-violet-100 leading-tight">
            {{ __('Create Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-inventory.card.card>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Create New Supplier</h1>

                <form wire:submit.prevent="save" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-inventory.form.form-input
                                id="name"
                                name="name"
                                wire:model.lazy="name"
                                label="Supplier Name"
                                placeholder="Enter supplier name"
                            />
                            @error('name') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-inventory.form.form-input
                                id="contact_person"
                                name="contact_person"
                                wire:model.lazy="contact_person"
                                label="Contact Person"
                                placeholder="Enter contact person (optional)"
                            />
                            @error('contact_person') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-inventory.form.form-input
                                id="email"
                                name="email"
                                type="email"
                                wire:model.lazy="email"
                                label="Email"
                                placeholder="Enter email (optional)"
                            />
                            @error('email') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <x-inventory.form.form-input
                                id="phone"
                                name="phone"
                                wire:model.lazy="phone"
                                label="Phone"
                                placeholder="Enter phone (optional)"
                            />
                            @error('phone') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <x-inventory.form.form-textarea
                            id="address"
                            name="address"
                            wire:model.lazy="address"
                            label="Address"
                            placeholder="Enter address (optional)"
                            rows="3"
                        />
                        @error('address') <span class="text-red-500 text-xs italic block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('suppliers.index') }}">
                            <x-inventory.button.button variant="outline">Cancel</x-inventory.button.button>
                        </a>
                        <x-inventory.button.button variant="primary" type="submit">Save Supplier</x-inventory.button.button>
                    </div>
                </form>
            </x-inventory.card.card>
        </div>
    </div>
</div>
