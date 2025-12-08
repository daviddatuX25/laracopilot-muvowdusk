<div>
    @if($visible && $message)
        <div class="fixed top-20 right-4 z-50 animate-fade-in">
            @if($type === 'success')
                <div class="bg-violet-50/95 dark:bg-emerald-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-emerald-300/50 text-violet-900 dark:text-emerald-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $message }}</span>
                    <button wire:click="close" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @elseif($type === 'error')
                <div class="bg-violet-50/95 dark:bg-red-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-red-300/50 text-violet-900 dark:text-red-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $message }}</span>
                    <button wire:click="close" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @elseif($type === 'warning')
                <div class="bg-violet-50/95 dark:bg-amber-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-amber-300/50 text-violet-900 dark:text-amber-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $message }}</span>
                    <button wire:click="close" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @else
                <div class="bg-violet-50/95 dark:bg-violet-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-violet-800/50 text-violet-900 dark:text-violet-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $message }}</span>
                    <button wire:click="close" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Session-based toasts (for post-redirect messages) -->
    @if(session()->has('toast_message'))
        <div class="fixed top-20 right-4 z-50 animate-fade-in">
            @php
                $toastType = session()->get('toast_type', 'info');
                $toastMessage = session()->get('toast_message');
            @endphp
            @if($toastType === 'success')
                <div class="bg-violet-50/95 dark:bg-emerald-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-emerald-300/50 text-violet-900 dark:text-emerald-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $toastMessage }}</span>
                    <button onclick="location.reload()" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @elseif($toastType === 'error')
                <div class="bg-violet-50/95 dark:bg-red-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-red-300/50 text-violet-900 dark:text-red-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $toastMessage }}</span>
                    <button onclick="location.reload()" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @elseif($toastType === 'warning')
                <div class="bg-violet-50/95 dark:bg-amber-900/20 backdrop-blur-xl border-2 border-violet-300/50 dark:border-amber-300/50 text-violet-900 dark:text-amber-100 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ $toastMessage }}</span>
                    <button onclick="location.reload()" class="ml-2 shrink-0 hover:opacity-70 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        <script>
            setTimeout(() => {
                const toast = document.querySelector('.animate-fade-in:last-child');
                if (toast) {
                    toast.style.animation = 'fadeOut 0.3s ease-in-out forwards';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        </script>
    @endif

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>

    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('hideToastAfterDelay', () => {
                setTimeout(() => {
                    @this.close();
                }, 5000);
            });

            // Listen for toast dispatches
            Livewire.on('toast', ({ type, message }) => {
                @this.toast(type, message);
            });
        });
    </script>
    @endscript
</div>
