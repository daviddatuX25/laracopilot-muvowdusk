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
            <x-inventory.button.button variant="primary" onclick="startZXingScanner()">
                Start Scanner
            </x-inventory.button.button>

            <x-inventory.button.button variant="danger" onclick="stopZXingScanner()">
                Stop Scanner
            </x-inventory.button.button>
        </div>
    </div>

    {{-- Product Result Section --}}
    @if (!empty($foundProductData))
        <x-inventory.card.card class="mt-6">
            <h3 class="font-bold text-lg mb-2">✓ Found Product: {{ $foundProductData['name'] }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-700"><strong>SKU:</strong> {{ $foundProductData['sku'] }}</p>
                    <p class="text-gray-700"><strong>Barcode:</strong> {{ $foundProductData['barcode'] ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Current Stock:</strong> <span class="font-bold text-lg">{{ $foundProductData['current_stock'] }}</span></p>
                    <p class="text-gray-700"><strong>Category:</strong> {{ $foundProductData['category_name'] }}</p>
                    <p class="text-gray-700"><strong>Supplier:</strong> {{ $foundProductData['supplier_name'] ?? 'N/A' }}</p>
                </div>
                @if (!empty($foundProductData) && false) {{-- Image removed for serialization --}}
                    <div class="flex justify-center items-center">
                        <img src="{{ asset('storage/' . $foundProduct->image_path) }}" alt="{{ $foundProduct->name }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
            </div>
        </x-inventory.card.card>
    @endif
</div>

@push('scripts')
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
// Use global BarcodeScanner module with component-specific override - only setup once
if (!window._barcodeScannerSetup) {
    window._barcodeScannerSetup = true;

    document.addEventListener('DOMContentLoaded', () => {
        if (!window.BarcodeScanner) return;

        window.BarcodeScanner.start = async function() {
            if (this.isScanning) return;
            this.isScanning = true;
            const status = document.getElementById('scanner-status');
            if (status) status.innerText = "Initializing camera…";

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

                // Start timeout timer
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
                            if (statusEl) statusEl.innerText = "✓ Barcode: " + result.text;

                            // Clear timeout on successful scan
                            if (this.scanTimeout) clearTimeout(this.scanTimeout);

                            try {
                                const response = await fetch(`/api/products/search?q=${encodeURIComponent(result.text)}`);
                                const data = await response.json();

                                if (data.product) {
                                    Livewire.dispatch('searchProductByBarcode', { barcode: result.text });
                                } else {
                                    alert('Product not found: ' + result.text);
                                }
                            } catch (err) {
                                console.error('Error fetching product:', err);
                                alert('Error searching product');
                            }

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
