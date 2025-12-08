<div x-data="{
    openModal: false,
    useCamera: false,
    init() {
        this.$watch('openModal', (value) => {
            if (value) {
                // Focus input after modal opens
                setTimeout(() => {
                    document.getElementById('barcode-input')?.focus();
                }, 100);
            } else {
                stopZXingScanner();
            }
        });
    }
}" class="w-full h-full">
    <!-- Trigger Button -->
    <button @click="openModal = true" class="w-full h-full flex flex-col items-center justify-center gap-3 p-8 rounded-lg border-2 border-dashed border-blue-300/50 dark:border-blue-700/50 hover:border-blue-400/80 dark:hover:border-blue-600/80 hover:bg-blue-50/20 dark:hover:bg-blue-900/10 transition group cursor-pointer backdrop-blur-sm">
        <svg class="w-12 h-12 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <div class="text-center">
            <h3 class="font-bold text-violet-900 dark:text-white text-lg">Smart Lookup</h3>
            <p class="text-sm text-violet-700 dark:text-violet-100">Scan or enter barcode to find or create new products.</p>
        </div>
    </button>

    <!-- Modal Overlay -->
    <div x-cloak x-show="openModal" class="fixed inset-0 bg-black/40 dark:bg-black/60 z-40 transition-opacity duration-300 backdrop-blur-sm" @click.self="openModal = false"></div>

    <!-- Modal Content -->
    <div x-cloak x-show="openModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.stop class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-lg shadow-2xl dark:shadow-2xl dark:shadow-black/50 border border-white/20 dark:border-gray-700/20 max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600/30 to-indigo-600/30 dark:from-blue-600/20 dark:to-indigo-600/20 backdrop-blur-sm text-violet-900 dark:text-white px-6 py-4 flex justify-between items-center border-b border-blue-200/50 dark:border-blue-800/50">
                <h2 class="text-xl font-bold">Smart Lookup</h2>
                <button @click="openModal = false; useCamera = false; stopZXingScanner(); $wire.clearSearch()" class="text-violet-900 dark:text-white hover:text-violet-700 dark:hover:text-violet-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <!-- Input Section - Always Visible -->
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-violet-900 dark:text-violet-100 mb-2">Enter or Scan Barcode</label>
                        <div class="flex gap-2">
                            <div class="flex-1 relative">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-violet-400 dark:text-violet-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2-5a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <input id="barcode-input"
                                    type="text"
                                    wire:model="manualBarcode"
                                    placeholder="Type or scan barcode..."
                                    class="w-full pl-10 pr-4 py-3 border-2 border-violet-200/50 dark:border-violet-800/50 bg-white/50 dark:bg-gray-800/50 text-violet-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 text-sm transition placeholder-violet-400 dark:placeholder-violet-500 backdrop-blur-sm"
                                    @keydown.enter="$wire.searchManualBarcode()"
                                    @input="setTimeout(() => $wire.searchManualBarcode(), 100)">
                            </div>
                            <button @click="useCamera = !useCamera; if(useCamera) setTimeout(() => startZXingScanner(), 100); else stopZXingScanner();"
                                class="px-4 py-2 bg-blue-600/30 hover:bg-blue-500/40 dark:bg-blue-600/20 dark:hover:bg-blue-500/30 border-2 border-blue-300/50 dark:border-blue-800/50 text-blue-900 dark:text-white rounded-lg transition font-medium flex items-center gap-2 whitespace-nowrap backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.219A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22a2 2 0 001.664.889H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="hidden sm:inline">Camera</span>
                            </button>
                        </div>
                    </div>

                    <!-- Camera Toggle Hint -->
                    <div class="text-xs text-violet-700 dark:text-violet-300 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm2 0h2v2h-2V8z" clip-rule="evenodd"/></svg>
                        <span x-text="useCamera ? 'Camera scanner active' : 'Type barcode or tap Camera to scan'"></span>
                    </div>
                </div>

                <!-- Camera Scanner Section -->
                @if (empty($foundProductData) && $notFound === false)
                    <div x-cloak x-show="useCamera" x-transition class="space-y-3">
                        <div wire:ignore class="bg-gradient-to-br from-violet-50 to-purple-50 dark:from-gray-700 dark:to-gray-900 rounded-lg overflow-hidden border-2 border-violet-200/50 dark:border-violet-800/50 backdrop-blur-sm">
                            <video id="qr-video" width="100%" height="400" class="w-full bg-gray-900"></video>
                        </div>
                        <div id="scanner-status" class="text-center text-sm text-violet-800 dark:text-violet-300 py-2 bg-blue-50/50 dark:bg-blue-900/20 backdrop-blur-sm rounded-lg border border-blue-200/30 dark:border-blue-800/30">
                            📷 Position barcode in the frame to scan...
                        </div>
                    </div>
                @endif

                <!-- Product Found State -->
                @if (!empty($foundProductData))
                    <div class="bg-green-50/50 dark:bg-green-900/10 border-2 border-green-300/50 dark:border-green-800/50 backdrop-blur-sm rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-bold text-violet-900 dark:text-white text-lg">{{ $foundProductData['name'] }}</h3>
                                <p class="text-sm text-violet-700 dark:text-violet-300 mt-1">SKU: {{ $foundProductData['sku'] }}</p>
                                <p class="text-sm text-violet-700 dark:text-violet-300">Barcode: {{ $foundProductData['barcode'] }}</p>
                            </div>
                        </div>

                        <!-- Product Details Grid -->
                        <div class="grid grid-cols-2 gap-3 text-sm mt-4">
                            <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded p-3 border-2 border-green-200/50 dark:border-green-800/50">
                                <p class="text-violet-700 dark:text-violet-300">Current Stock</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $foundProductData['current_stock'] }}</p>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded p-3 border-2 border-green-200/50 dark:border-green-800/50">
                                <p class="text-violet-700 dark:text-violet-300">Category</p>
                                <p class="font-semibold text-violet-900 dark:text-white">{{ $foundProductData['category_name'] }}</p>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded p-3 border-2 border-green-200/50 dark:border-green-800/50">
                                <p class="text-violet-700 dark:text-violet-300">Reorder Level</p>
                                <p class="text-lg font-bold text-violet-900 dark:text-white">{{ $foundProductData['reorder_level'] }}</p>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded p-3 border-2 border-green-200/50 dark:border-green-800/50">
                                <p class="text-violet-700 dark:text-violet-300">Supplier</p>
                                <p class="font-semibold text-violet-900 dark:text-white">{{ $foundProductData['supplier_name'] }}</p>
                            </div>
                        </div>

                        <!-- Product Image -->
                        @if (!empty($foundProductData))
                            <div class="mt-4 flex justify-center">
                                <!-- Image removed - not serializable with array storage -->
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Product Not Found State -->
                @if ($notFound)
                    <div class="bg-amber-50/50 dark:bg-amber-900/10 border-2 border-amber-300/50 dark:border-amber-800/50 backdrop-blur-sm rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-amber-900 dark:text-amber-200">Product not found</h3>
                                <p class="text-sm text-amber-800 dark:text-amber-300 mt-1">No product found with barcode: <strong>{{ $barcodeForCreate }}</strong></p>
                                <p class="text-sm text-amber-800 dark:text-amber-300 mt-2">Would you like to create a new product with this barcode?</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Session Messages -->
                @if (session('success'))
                    <div class="bg-green-50/50 dark:bg-green-900/10 border-2 border-green-300/50 dark:border-green-800/50 backdrop-blur-sm rounded-lg p-3 text-sm text-green-700 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50/50 dark:bg-red-900/10 border-2 border-red-300/50 dark:border-red-800/50 backdrop-blur-sm rounded-lg p-3 text-sm text-red-700 dark:text-red-300">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="bg-white/20 dark:bg-gray-800/20 backdrop-blur-sm border-t border-violet-200/30 dark:border-violet-800/30 px-6 py-4 flex gap-2 justify-end">
                <button @click="openModal = false; $wire.clearSearch()" class="px-4 py-2 text-violet-900 dark:text-white bg-white/50 dark:bg-gray-800/50 border-2 border-violet-200/50 dark:border-violet-800/50 rounded-lg hover:bg-white/70 dark:hover:bg-gray-700/70 transition font-medium backdrop-blur-sm">
                    Close
                </button>

                @if (!empty($foundProductData))
                    <a href="{{ route('stock-movements.adjust') }}?product_id={{ $foundProductData['id'] }}" class="px-4 py-2 bg-orange-600/30 hover:bg-orange-500/40 dark:bg-orange-600/20 dark:hover:bg-orange-500/30 border-2 border-orange-300/50 dark:border-orange-800/50 text-orange-900 dark:text-white rounded-lg transition font-medium flex items-center gap-2 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Modify Stock
                    </a>
                    <a href="{{ route('products.edit', $foundProductData['id']) }}" class="px-4 py-2 bg-blue-600/30 hover:bg-blue-500/40 dark:bg-blue-600/20 dark:hover:bg-blue-500/30 border-2 border-blue-300/50 dark:border-blue-800/50 text-blue-900 dark:text-white rounded-lg transition font-medium flex items-center gap-2 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        View Product
                    </a>
                @elseif ($notFound)
                    <a href="{{ route('products.create', ['barcode' => $barcodeForCreate]) }}" class="px-4 py-2 bg-green-600/30 hover:bg-green-500/40 dark:bg-green-600/20 dark:hover:bg-green-500/30 border-2 border-green-300/50 dark:border-green-800/50 text-green-900 dark:text-white rounded-lg transition font-medium flex items-center gap-2 backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Product
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ZXing Scanner Script -->
@push('scripts')
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
// Wait for global scanner to be ready - only setup once
if (!window._productLookupScannerSetup) {
    window._productLookupScannerSetup = true;

    document.addEventListener('DOMContentLoaded', () => {
        if (!window.BarcodeScanner) return;

        // Override for this component - dispatch custom event
        window.BarcodeScanner.start = async function() {
            if (this.isScanning) return;

            this.isScanning = true;
            const status = document.getElementById('scanner-status');
            if (status) status.innerText = "🔄 Initializing camera…";

            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
                    if (status) status.innerText = "❌ Camera access not available on this device/connection.";
                    this.isScanning = false;
                    return;
                }

                if (!this.zxingReader) {
                    this.zxingReader = new ZXing.BrowserMultiFormatReader();
                }

                const devices = await navigator.mediaDevices.enumerateDevices();
                const cameras = devices.filter(d => d.kind === "videoinput");

                if (!cameras.length) {
                    if (status) status.innerText = "❌ No camera detected.";
                    this.isScanning = false;
                    return;
                }

                this.activeCameraId = cameras.find(c => c.label.toLowerCase().includes("back"))?.deviceId || cameras[0].deviceId;
                if (status) status.innerText = "📷 Camera active. Point at barcode...";

                // Start timeout - use direct setTimeout
                if (this.scanTimeout) clearTimeout(this.scanTimeout);
                this.scanTimeout = setTimeout(() => {
                    if (this.isScanning) {
                        const statusEl = document.getElementById('scanner-status');
                        if (statusEl) statusEl.innerText = "⏱️ Timeout: No barcode detected. Stopping scanner...";
                        this.stop();
                    }
                }, this.timeoutDuration || 60000);

                this.zxingReader.decodeFromVideoDevice(
                    this.activeCameraId,
                    'qr-video',
                    async (result, error) => {
                        if (result) {
                            const statusEl = document.getElementById('scanner-status');
                            if (statusEl) statusEl.innerText = "✓ Found: " + result.text;

                            // Clear timeout on success
                            if (this.scanTimeout) clearTimeout(this.scanTimeout);

                            // Dispatch custom event for this component
                            Livewire.dispatch('searchProductByBarcode', { barcode: result.text });
                            this.stop();
                        }
                        if (error && error.name !== 'NotFoundException') {
                            console.warn("Decode error:", error.name);
                        }
                    }
                );
            } catch (error) {
                const statusEl = document.getElementById('scanner-status');
                if (statusEl) {
                    if (error.message.includes('Permission denied')) {
                        statusEl.innerText = "❌ Camera permission denied.";
                    } else if (error.message.includes('enumerateDevices')) {
                        statusEl.innerText = "❌ Camera access not available. Use HTTPS.";
                    } else {
                        statusEl.innerText = "❌ Error: " + error.message;
                    }
                }
                this.isScanning = false;
                if (this.scanTimeout) clearTimeout(this.scanTimeout);
            }
        };
    });
}
</script>
@endpush
