<div wire:poll-10000ms="refreshAlerts">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alerts') }}
            @if($totalPending > 0)
                <span class="inline-flex items-center justify-center px-3 py-1 ml-2 text-sm font-medium text-white bg-red-600 rounded-full animate-pulse">
                    {{ $totalPending }}
                </span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl font-semibold text-gray-800">Pending Alerts</h1>
                            <div class="flex items-center gap-2">
                                <div class="relative inline-flex items-center">
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500 animate-pulse"></span>
                                </div>
                                <span class="text-sm text-gray-600">Live</span>
                            </div>
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                            <span class="block sm:inline">{{ session('message') }}</span>
                        </div>
                    @endif

                    <div class="mt-6 text-gray-500">
                        @if ($alerts->isEmpty())
                            <div class="flex flex-col items-center justify-center py-12">
                                <svg class="w-16 h-16 text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-xl text-gray-600 font-semibold">No Pending Alerts</p>
                                <p class="text-gray-500 mt-2">All systems are running smoothly!</p>
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Product
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Message
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Age
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($alerts as $alert)
                                            <tr class="hover:bg-gray-50 transition {{ $alert->isUrgent() ? 'bg-red-50' : '' }} {{ !$alert->isSeen() ? 'bg-blue-50' : '' }}">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if (!$alert->isSeen())
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-3 h-3 bg-red-600 rounded-full animate-pulse"></div>
                                                            <span class="text-xs font-semibold text-red-700">UNSEEN</span>
                                                        </div>
                                                    @else
                                                        <span class="text-xs font-semibold text-gray-500">SEEN</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $alert->product->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $alert->type === 'low_stock' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                                        @if($alert->type === 'low_stock')
                                                            ⚠️ Low Stock
                                                        @else
                                                            🔴 Out of Stock
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900">{{ $alert->message }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-600">
                                                        {{ $alert->getFormattedAge() }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-2 justify-end">
                                                    @if (!$alert->isSeen())
                                                        <button wire:click="markAsSeen({{ $alert->id }})"
                                                                class="inline-flex items-center px-3 py-1 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition text-xs">
                                                            👁️ Mark Seen
                                                        </button>
                                                    @endif
                                                    <button wire:click="resolveAlert({{ $alert->id }})"
                                                            wire:confirm="Are you sure you want to resolve this alert?"
                                                            class="inline-flex items-center px-3 py-1 rounded-md text-white bg-green-600 hover:bg-green-700 transition text-xs">
                                                        ✓ Resolve
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
