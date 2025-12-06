<div>
    @if($visible && $message)
        <div wire:click="close" class="fixed top-4 right-4 z-50 cursor-pointer animate-fade-in">
            @if($type === 'success')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-lg flex items-center gap-2">
                    <span>✓</span>
                    <span>{{ $message }}</span>
                </div>
            @elseif($type === 'error')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-lg flex items-center gap-2">
                    <span>✕</span>
                    <span>{{ $message }}</span>
                </div>
            @elseif($type === 'warning')
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded shadow-lg flex items-center gap-2">
                    <span>⚠</span>
                    <span>{{ $message }}</span>
                </div>
            @else
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded shadow-lg flex items-center gap-2">
                    <span>ℹ</span>
                    <span>{{ $message }}</span>
                </div>
            @endif
        </div>
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
