<div wire:poll-5000ms="loadNotifications" class="ml-3 relative" x-data="{ notificationOpen: false }">
    <button @click="notificationOpen = !notificationOpen" class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none" type="button">
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/></svg>
        @if($unseenCount > 0)
            <div class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full top-0 start-3 animate-pulse"></div>
        @endif
    </button>

    <!-- Notification Dropdown Panel -->
    <div x-show="notificationOpen"
         @click.away="notificationOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 md:w-96 max-w-sm md:max-w-md bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50"
         style="display: none;">

        <!-- Header -->
        <div class="px-3 md:px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Alerts</h3>
            @if($unseenCount > 0)
                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    {{ $unseenCount }}
                </span>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @if($notifications->isEmpty())
                <div class="px-3 md:px-4 py-8 text-center">
                    <svg class="w-12 h-12 text-green-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-gray-600 font-medium">All Clear!</p>
                    <p class="text-gray-500 text-sm mt-1">No pending alerts</p>
                </div>
            @else
                @foreach($notifications as $notification)
                    <div wire:key="notification-{{ $notification->id }}"
                         @class([
                             'notification-item px-3 md:px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer',
                             'ring-l-4 ring-blue-500 bg-blue-50' => !$notification->isSeen(),
                             'bg-red-50' => $notification->isSeen() && $notification->type === 'out_of_stock',
                             'bg-yellow-50' => $notification->isSeen() && $notification->type !== 'out_of_stock',
                         ])
                         wire:click="markAsSeen({{ $notification->id }})">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    @if (!$notification->isSeen())
                                        <div class="w-2 h-2 bg-red-600 rounded-full shrink-0 animate-pulse"></div>
                                    @endif
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $notification->type === 'low_stock' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                        @if($notification->type === 'low_stock')
                                            ⚠️ Low Stock
                                        @else
                                            🔴 Out of Stock
                                        @endif
                                    </span>
                                </div>
                                <p class="alert-message text-xs md:text-sm font-medium text-gray-900 truncate">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ $notification->getFormattedAge() }}
                                </p>
                            </div>
                            <button wire:click.stop="resolveAlert({{ $notification->id }})"
                                    class="ml-2 text-gray-400 hover:text-gray-600 shrink-0">
                                <svg class="w-4 md:w-5 h-4 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Footer -->
        @if(!$notifications->isEmpty())
            <div class="px-3 md:px-4 py-3 border-t border-gray-200 text-center bg-gray-50">
                <a href="{{ route('alerts.index') }}" class="text-xs md:text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                    View All Alerts →
                </a>
            </div>
        @endif
    </div>
</div>
