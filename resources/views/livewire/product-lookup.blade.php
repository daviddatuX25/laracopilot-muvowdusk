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
    <button @click="openModal = true" class="w-full h-full flex flex-col items-center justify-center gap-3 p-8 rounded-lg border-2 border-dashed border-blue-300 dark:border-blue-500 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group cursor-pointer">
        <svg class="w-12 h-12 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <div class="text-center">
            <h3 class="font-bold text-gray-900 dark:text-white text-lg">Smart Lookup</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Scan or enter barcode to find or create new products.</p>
        </div>
    </button>

    <!-- Modal Overlay -->
    <div x-cloak x-show="openModal" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-40 transition-opacity duration-300" @click.self="openModal = false"></div>

    <!-- Modal Content -->
    <div x-cloak x-show="openModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.stop class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl dark:shadow-2xl dark:shadow-black/50 max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="bg-blue-500 dark:bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Smart Lookup</h2>
                <button @click="openModal = false; useCamera = false; stopZXingScanner(); $wire.clearSearch()" class="text-white hover:text-blue-100 dark:hover:text-blue-200 transition">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter or Scan Barcode</label>
                        <div class="flex gap-2">
                            <div class="flex-1 relative">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2-5a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <input id="barcode-input"
                                    type="text"
                                    wire:model="manualBarcode"
                                    placeholder="Type or scan barcode..."
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400 text-sm transition placeholder-gray-400 dark:placeholder-gray-500"
                                    @keydown.enter="$wire.searchManualBarcode()"
                                    @input="setTimeout(() => $wire.searchManualBarcode(), 100)">
                            </div>
                            <button @click="useCamera = !useCamera; if(useCamera) setTimeout(() => startZXingScanner(), 100); else stopZXingScanner();"
                                class="px-4 py-2 bg-indigo-600 dark:bg-indigo-700 hover:bg-indigo-700 dark:hover:bg-indigo-800 text-white rounded-lg transition font-medium flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.219A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22a2 2 0 001.664.889H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="hidden sm:inline">Camera</span>
                            </button>
                        </div>
                    </div>

                    <!-- Camera Toggle Hint -->
                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm2 0h2v2h-2V8z" clip-rule="evenodd"/></svg>
                        <span x-text="useCamera ? 'Camera scanner active' : 'Type barcode or tap Camera to scan'"></span>
                    </div>
                </div>

                <!-- Camera Scanner Section -->
                @if (empty($foundProductData) && $notFound === false)
                    <div x-cloak x-show="useCamera" x-transition class="space-y-3">
                        <div wire:ignore class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden border-2 border-gray-300 dark:border-gray-600">
                            <video id="qr-video" width="100%" height="400" class="w-full bg-gray-50 dark:bg-gray-900"></video>
                        </div>
                        <div id="scanner-status" class="text-center text-sm text-gray-600 dark:text-gray-300 py-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            📷 Position barcode in the frame to scan...
                        </div>
                    </div>
                @endif

                <!-- Product Found State -->
                @if (!empty($foundProductData))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg">{{ $foundProductData['name'] }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">SKU: {{ $foundProductData['sku'] }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Barcode: {{ $foundProductData['barcode'] }}</p>
                            </div>
                        </div>

                        <!-- Product Details Grid -->
                        <div class="grid grid-cols-2 gap-3 text-sm mt-4">
                            <div class="bg-white dark:bg-gray-700 rounded p-3 border border-green-100 dark:border-green-900">
                                <p class="text-gray-600 dark:text-gray-300">Current Stock</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $foundProductData['current_stock'] }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded p-3 border border-green-100 dark:border-green-900">
                                <p class="text-gray-600 dark:text-gray-300">Category</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $foundProductData['category_name'] }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded p-3 border border-green-100 dark:border-green-900">
                                <p class="text-gray-600 dark:text-gray-300">Reorder Level</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $foundProductData['reorder_level'] }}</p>
                            </div>
                            <div class="bg-white dark:bg-gray-700 rounded p-3 border border-green-100 dark:border-green-900">
                                <p class="text-gray-600 dark:text-gray-300">Supplier</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $foundProductData['supplier_name'] }}</p>
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
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-yellow-900 dark:text-yellow-200">Product not found</h3>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">No product found with barcode: <strong>{{ $barcodeForCreate }}</strong></p>
                                <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-2">Would you like to create a new product with this barcode?</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Session Messages -->
                @if (session('success'))
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3 text-sm text-green-700 dark:text-green-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 text-sm text-red-700 dark:text-red-300">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 px-6 py-4 flex gap-2 justify-end">
                <button @click="openModal = false; $wire.clearSearch()" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 transition font-medium">
                    Close
                </button>

                @if (!empty($foundProductData))
                    <a href="{{ route('stock-movements.adjust') }}?product_id={{ $foundProductData['id'] }}" class="px-4 py-2 bg-orange-600 dark:bg-orange-700 hover:bg-orange-700 dark:hover:bg-orange-800 text-white rounded-lg transition font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Adjust Stock
                    </a>
                    <a href="{{ route('products.edit', $foundProductData['id']) }}" class="px-4 py-2 bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white rounded-lg transition font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        View Product
                    </a>
                @elseif ($notFound)
                    <a href="{{ route('products.create', ['barcode' => $barcodeForCreate]) }}" class="px-4 py-2 bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white rounded-lg transition font-medium flex items-center gap-2">
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
