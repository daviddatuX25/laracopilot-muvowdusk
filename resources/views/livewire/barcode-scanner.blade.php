<div>
    {{-- Scanner Section --}}
    <div class="p-4 bg-white shadow rounded">
        <h2 class="text-lg font-bold mb-3">ZXing Barcode Scanner</h2>

        {{-- Scanner Video Output --}}
        <div wire:ignore>
            <video id="qr-video" width="400" height="300" class="border rounded"></video>
        </div>

        <div id="scanner-status" class="mt-2 text-gray-600 text-sm"></div>

        <div class="flex gap-2 mt-4">
            <button onclick="startZXingScanner()"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Start Scanner
            </button>

            <button onclick="stopZXingScanner()"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Stop Scanner
            </button>
        </div>
    </div>

    {{-- Product Result Section --}}
    @if ($foundProduct)
        <div class="mt-6 p-4 border rounded bg-green-50">
            <h3 class="font-bold text-lg mb-2">✓ Found Product: {{ $foundProduct->name }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-700"><strong>SKU:</strong> {{ $foundProduct->sku }}</p>
                    <p class="text-gray-700"><strong>Barcode:</strong> {{ $foundProduct->barcode ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Current Stock:</strong> <span class="font-bold text-lg">{{ $foundProduct->current_stock }}</span></p>
                    <p class="text-gray-700"><strong>Category:</strong> {{ $foundProduct->category->name }}</p>
                    <p class="text-gray-700"><strong>Supplier:</strong> {{ $foundProduct->supplier->name ?? 'N/A' }}</p>
                </div>
                @if ($foundProduct->image_path)
                    <div class="flex justify-center items-center">
                        <img src="{{ asset('storage/' . $foundProduct->image_path) }}" alt="{{ $foundProduct->name }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

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
    status.innerText = "Initializing camera…";

    try {
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

        // Start scanning with higher resolution
        zxingReader.decodeFromVideoDevice(
            activeCameraId,
            'qr-video',
            async (result, error) => {
                if (result) {
                    console.log("✓ Barcode detected:", result.text);
                    document.getElementById('scanner-status').innerText = "✓ Barcode: " + result.text;

                    // Fetch product data from API
                    try {
                        const response = await fetch(`/api/products/search?q=${encodeURIComponent(result.text)}`);
                        const data = await response.json();

                        console.log("API Response:", data);

                        if (data.product) {
                            console.log("Product found, dispatching event...");
                            // Dispatch to Livewire component with the barcode
                            Livewire.dispatch('searchProductByBarcode', { barcode: result.text });
                            console.log("Event dispatched!");
                        } else {
                            console.warn('Product not found for barcode:', result.text);
                            alert('Product not found: ' + result.text);
                        }
                    } catch (err) {
                        console.error('Error fetching product:', err);
                        alert('Error searching product');
                    }

                    stopZXingScanner();
                }

                if (error && error.name !== 'NotFoundException') {
                    console.warn("Decode error:", error.name, error.message);
                }
            }
        );


    } catch (error) {
        console.error("Scanner error:", error);
        status.innerText = "❌ Error: " + error.message;
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

    status.innerText = "Scanner stopped.";
}

// Auto-stop on Livewire navigation or page unload
document.addEventListener('livewire:navigated', stopZXingScanner);
window.addEventListener('beforeunload', stopZXingScanner);
</script>
@endpush
