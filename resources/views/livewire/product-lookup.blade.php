<div x-data="{
    openModal: false,
    manualMode: false,
    init() {
        this.$watch('openModal', (value) => {
            if (!value) {
                stopZXingScanner();
            }
        });
    }
}" class="w-full h-full">
    <!-- Trigger Button -->
    <button @click="openModal = true" class="w-full h-full flex flex-col items-center justify-center gap-3 p-8 rounded-lg border-2 border-dashed border-blue-300 hover:border-blue-500 hover:bg-blue-50 transition group cursor-pointer">
        <svg class="w-12 h-12 text-blue-600 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <div class="text-center">
            <h3 class="font-bold text-gray-900 text-lg">Barcode Lookup</h3>
            <p class="text-sm text-gray-600">Scan barcode to find products</p>
        </div>
    </button>

    <!-- Modal Overlay -->
    <div x-show="openModal" class="fixed inset-0 bg-transparent z-50 flex items-center justify-center p-4" @click.self="openModal = false" style="display: none;">
        <div @click.stop class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="bg-blue-500 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Barcode Lookup</h2>
                <button @click="openModal = false; $wire.clearSearch()" class="text-white hover:text-blue-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <!-- Camera Scanner -->
                @if (!$foundProduct && !$notFound)
                    <div class="space-y-4">
                        <!-- Video Element -->
                        <div wire:ignore class="bg-gray-100 rounded-lg overflow-hidden border-2 border-gray-300">
                            <video id="qr-video" width="100%" height="400" class="w-full bg-gray-50"></video>
                        </div>

                        <!-- Scanner Status -->
                        <div id="scanner-status" class="text-center text-sm text-gray-600 py-2 bg-gray-50 rounded-lg">
                            Camera scanner ready
                        </div>

                        <!-- Scanner Controls -->
                        <div class="flex gap-2">
                            <button onclick="startZXingScanner()" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-semibold">
                                ▶️ Start Scanning
                            </button>
                            <button onclick="stopZXingScanner()" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-semibold">
                                ⏹️ Stop
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Product Found State -->
                @if ($foundProduct)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg">{{ $foundProduct->name }}</h3>
                                <p class="text-sm text-gray-600 mt-1">SKU: {{ $foundProduct->sku }}</p>
                                <p class="text-sm text-gray-600">Barcode: {{ $foundProduct->barcode }}</p>
                            </div>
                        </div>

                        <!-- Product Details Grid -->
                        <div class="grid grid-cols-2 gap-3 text-sm mt-4">
                            <div class="bg-white rounded p-3 border border-green-100">
                                <p class="text-gray-600">Current Stock</p>
                                <p class="text-2xl font-bold text-green-600">{{ $foundProduct->current_stock }}</p>
                            </div>
                            <div class="bg-white rounded p-3 border border-green-100">
                                <p class="text-gray-600">Category</p>
                                <p class="font-semibold text-gray-900">{{ $foundProduct->category?->name ?? 'N/A' }}</p>
                            </div>
                            <div class="bg-white rounded p-3 border border-green-100">
                                <p class="text-gray-600">Reorder Level</p>
                                <p class="text-lg font-bold text-gray-900">{{ $foundProduct->reorder_level }}</p>
                            </div>
                            <div class="bg-white rounded p-3 border border-green-100">
                                <p class="text-gray-600">Supplier</p>
                                <p class="font-semibold text-gray-900">{{ $foundProduct->supplier?->name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Product Image -->
                        @if ($foundProduct->image_path)
                            <div class="mt-4 flex justify-center">
                                <img src="{{ asset('storage/' . $foundProduct->image_path) }}" alt="{{ $foundProduct->name }}" class="w-40 h-40 object-cover rounded-lg border border-green-100">
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Product Not Found State -->
                @if ($notFound)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-yellow-900">Product not found</h3>
                                <p class="text-sm text-yellow-700 mt-1">No product found with barcode: <strong>{{ $barcodeForCreate }}</strong></p>
                                <p class="text-sm text-yellow-700 mt-2">Would you like to create a new product with this barcode?</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Session Messages -->
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex gap-2 justify-end">
                <button @click="openModal = false; $wire.clearSearch()" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition font-medium">
                    Close
                </button>

                @if ($foundProduct)
                    <a href="{{ route('products.edit', $foundProduct->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition font-medium flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        View Product
                    </a>
                @elseif ($notFound)
                    <a href="{{ route('products.create', ['barcode' => $barcodeForCreate]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-medium flex items-center gap-2">
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
let zxingReader = null;
let activeCameraId = null;
let isScanning = false;

async function startZXingScanner() {
    if (isScanning) return;

    isScanning = true;
    const status = document.getElementById('scanner-status');
    status.innerText = "🔄 Initializing camera…";

    try {
        // Check if mediaDevices is available
        if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
            status.innerText = "❌ Camera access not available on this device/connection.";
            console.error("mediaDevices not supported");
            isScanning = false;
            return;
        }

        if (!zxingReader) {
            zxingReader = new ZXing.BrowserMultiFormatReader();
            console.log("ZXing reader initialized");
        }

        // Get cameras
        const devices = await navigator.mediaDevices.enumerateDevices();
        const cameras = devices.filter(d => d.kind === "videoinput");

        if (!cameras.length) {
            status.innerText = "❌ No camera detected.";
            isScanning = false;
            return;
        }

        // Prefer back camera on mobile
        activeCameraId = cameras.find(c => c.label.toLowerCase().includes("back"))?.deviceId
                         || cameras[0].deviceId;

        status.innerText = "📷 Camera active. Point at barcode...";

        // Start scanning
        zxingReader.decodeFromVideoDevice(
            activeCameraId,
            'qr-video',
            async (result, error) => {
                if (result) {
                    console.log("✓ Barcode detected:", result.text);
                    document.getElementById('scanner-status').innerText = "✓ Found: " + result.text;

                    // Dispatch to Livewire component
                    console.log("Dispatching event with barcode:", result.text);
                    Livewire.dispatch('searchProductByBarcode', { barcode: result.text });
                    console.log("Event dispatched!");

                    // Stop scanner after successful scan
                    stopZXingScanner();
                }                if (error && error.name !== 'NotFoundException') {
                    console.warn("Decode error:", error.name);
                }
            }
        );

    } catch (error) {
        console.error("Scanner error:", error);
        const status = document.getElementById('scanner-status');
        if (error.message.includes('Permission denied')) {
            status.innerText = "❌ Camera permission denied. Please enable camera access in settings.";
        } else if (error.message.includes('enumerateDevices')) {
            status.innerText = "❌ Camera access not available. Ensure you're on HTTPS.";
        } else {
            status.innerText = "❌ Error: " + error.message;
        }
        isScanning = false;
    }
}

async function stopZXingScanner() {
    if (!isScanning) return;

    isScanning = false;
    const status = document.getElementById('scanner-status');

    try {
        if (zxingReader) {
            await zxingReader.reset();
            console.log("Scanner stopped");
        }
    } catch (error) {
        console.error("Error stopping scanner:", error);
    }

    status.innerText = "⏸️ Scanner stopped.";
}

// Auto-stop on Livewire navigation or page unload
document.addEventListener('livewire:navigated', stopZXingScanner);
window.addEventListener('beforeunload', stopZXingScanner);
</script>
@endpush
