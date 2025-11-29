<div x-data="{
    scannerOpen: false,
    init() {
        this.$watch('scannerOpen', (value) => {
            if (!value) {
                stopZXingScanner();
            }
        });
    }
}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Adjustment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="mt-8 text-2xl">
                        Adjust Stock
                    </div>

                    <form wire:submit.prevent="adjustStock" class="mt-6">
                        <!-- Product Selection Section -->
                        <div class="mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <!-- Scanner Toggle -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Scanner</label>
                                    <button type="button" @click="scannerOpen = !scannerOpen" class="relative z-10 w-full inline-flex items-center justify-center px-6 py-3" :class="scannerOpen ? 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow-lg focus:ring-red-500' : 'bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 shadow focus:ring-purple-500'" class="border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 pointer-events-auto">
                                        <template x-if="scannerOpen">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                Disable Scanner
                                            </span>
                                        </template>
                                        <template x-if="!scannerOpen">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 1114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                                Enable Scanner
                                            </span>
                                        </template>
                                    </button>
                                </div>

                                <!-- Manual Search -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Manual Search</label>
                                    <input type="text" id="search" wire:model.debounce-500ms="search" placeholder="Search by name, SKU or barcode..." class="w-full px-4 py-3 border-2 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-lg shadow-sm font-medium placeholder-gray-400 transition duration-200">
                                    @error('selectedProductId') <span class="text-red-500 text-xs italic mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Video Scanner Section -->
                            <div x-show="scannerOpen" class="mb-6 bg-gradient-to-br from-gray-900 to-gray-800 p-4 border-2 border-purple-400 rounded-xl shadow-2xl overflow-hidden">
                                    <div class="relative w-full bg-black rounded-lg overflow-hidden" style="aspect-ratio: 4/3;">
                                        <video id="qr-video" wire:ignore class="w-full h-full object-cover"></video>

                                        <!-- Scanning Guide Overlay -->
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="relative w-64 h-48 border-4 border-yellow-400 rounded-2xl shadow-inner" style="box-shadow: inset 0 0 20px rgba(250, 204, 21, 0.3);">
                                                <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-yellow-400"></div>
                                                <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-yellow-400"></div>
                                                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-yellow-400"></div>
                                                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-yellow-400"></div>
                                            </div>
                                        </div>

                                        <!-- Status Badge -->
                                        <div class="absolute top-4 right-4">
                                            <div class="flex items-center gap-2 bg-black/70 backdrop-blur px-3 py-2 rounded-full">
                                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                                <span class="text-xs font-semibold text-white">Scanning</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Scanner Status Message -->
                                    <div class="mt-4 p-3 bg-purple-50 border border-purple-200 rounded-lg">
                                        <p id="scanner-status" class="text-center text-sm font-medium text-purple-800">📷 Position barcode in the frame to scan...</p>
                                    </div>

                                    <!-- Camera Controls -->
                                    <div class="flex gap-3 justify-center mt-4">
                                        <button type="button" onclick="startZXingScanner()" class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/></svg>
                                            Start
                                        </button>
                                        <button type="button" onclick="stopZXingScanner()" class="flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4zm6 4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                                            Stop
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Manual Barcode Input Section -->
                            @if($showManualInput && !$useVideoScanner)
                                <div class="mb-6 p-4 border-2 border-blue-300 rounded-lg bg-blue-50 shadow-sm">
                                    <label for="barcodeInput" class="block text-gray-700 text-sm font-semibold mb-3">Enter Barcode/SKU:</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="barcodeInput" wire:model="barcodeInput" placeholder="Scan or type barcode/SKU..." autofocus class="flex-1 px-4 py-2 border-2 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 rounded-lg font-medium transition duration-200">
                                        <button type="button" wire:click="searchByBarcode" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Search Results Dropdown -->
                            @if(!empty($search) && empty($selectedProduct) && count($products) > 0)
                                <ul class="mb-6 border-2 border-blue-300 rounded-lg shadow-lg bg-white overflow-hidden max-h-64 overflow-y-auto z-10 relative">
                                    @foreach($products as $product)
                                        <li wire:click="selectProduct({{ $product->id }})" class="p-4 border-b last:border-b-0 hover:bg-blue-50 cursor-pointer transition flex justify-between items-center group">
                                            <div class="flex-1">
                                                <p class="font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                                            </div>
                                            <span class="bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full">Stock: {{ $product->current_stock }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        @if($selectedProduct)
                            <!-- Selected Product Info -->
                            <div class="mb-6 p-4 border-2 border-green-500 rounded bg-green-50">
                                <h3 class="font-bold text-lg mb-3 text-green-800">✓ Selected: {{ $selectedProduct->name }}</h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600">SKU</p>
                                        <p class="font-bold">{{ $selectedProduct->sku }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Current Stock</p>
                                        <p class="font-bold text-lg">{{ $selectedProduct->current_stock }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Category</p>
                                        <p class="font-bold">{{ $selectedProduct->category->name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Reorder Level</p>
                                        <p class="font-bold {{ $selectedProduct->current_stock <= $selectedProduct->reorder_level ? 'text-red-600' : 'text-green-600' }}">{{ $selectedProduct->reorder_level }}</p>
                                    </div>
                                </div>
                                <button type="button" wire:click="$set('selectedProductId', null)" class="mt-3 text-sm text-red-600 hover:text-red-800 font-bold">
                                    Change Product
                                </button>
                            </div>

                            <!-- Movement Type Selection -->
                            <div class="mb-6">
                                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Movement Type:</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="button" wire:click="$set('type', 'in')" class="p-2 border-2 rounded {{ $type === 'in' ? 'border-green-500 bg-green-50' : 'border-gray-300' }} text-center font-bold {{ $type === 'in' ? 'text-green-700' : 'text-gray-700' }}">
                                        ↑ In (Add)
                                    </button>
                                    <button type="button" wire:click="$set('type', 'out')" class="p-2 border-2 rounded {{ $type === 'out' ? 'border-red-500 bg-red-50' : 'border-gray-300' }} text-center font-bold {{ $type === 'out' ? 'text-red-700' : 'text-gray-700' }}">
                                        ↓ Out (Remove)
                                    </button>
                                    <button type="button" wire:click="$set('type', 'adjustment')" class="p-2 border-2 rounded {{ $type === 'adjustment' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }} text-center font-bold {{ $type === 'adjustment' ? 'text-blue-700' : 'text-gray-700' }}">
                                        ⟷ Adjust
                                    </button>
                                </div>
                            </div>

                            <!-- Quantity Selection -->
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Select Quantity:</label>
                                <div class="grid grid-cols-4 gap-2 mb-4">
                                    @foreach($presetQuantities as $qty)
                                        <button type="button" wire:click="setQuantity({{ $qty }})" class="p-3 border-2 rounded font-bold {{ $quantity == $qty ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-300 text-gray-700' }}">
                                            {{ $qty }}
                                        </button>
                                    @endforeach
                                </div>

                                <div>
                                    <label for="customQuantity" class="text-gray-700 text-sm font-bold">Custom Quantity:</label>
                                    <div class="flex gap-2">
                                        <input type="number" id="customQuantity" wire:model="customQuantity" min="1" placeholder="Enter custom amount" class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <button type="button" wire:click="updateCustomQuantity" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Apply
                                        </button>
                                    </div>
                                </div>

                                @if($quantity)
                                    <p class="mt-3 p-2 bg-gray-100 rounded">
                                        <strong>Selected Quantity:</strong> {{ $quantity }} units
                                    </p>
                                @endif
                                @error('quantity') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                            </div>

                            <!-- Reason for Adjustment -->
                            @if($type === 'adjustment')
                                <div class="mb-6">
                                    <label for="reason" class="block text-gray-700 text-sm font-bold mb-2">Reason for Adjustment:</label>
                                    <textarea id="reason" wire:model="reason" placeholder="e.g., Damaged stock, inventory count discrepancy..." class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3"></textarea>
                                    @error('reason') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                                </div>
                            @else
                                @if($type === 'in')
                                    <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded">
                                        <p class="text-sm text-green-700"><strong>Preview:</strong> Stock will increase from {{ $selectedProduct->current_stock }} to {{ (int)($selectedProduct->current_stock + ($quantity ?: 0)) }} units</p>
                                    </div>
                                @else
                                    <div class="mb-6 p-3 bg-red-50 border border-red-200 rounded">
                                        <p class="text-sm text-red-700"><strong>Preview:</strong> Stock will decrease from {{ $selectedProduct->current_stock }} to {{ max(0, (int)($selectedProduct->current_stock - ($quantity ?: 0))) }} units</p>
                                    </div>
                                @endif
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between gap-4">
                                <button type="submit" {{ empty($quantity) ? 'disabled' : '' }} class="bg-blue-500 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition ease-in-out duration-150">
                                    Confirm Adjustment
                                </button>
                                <button type="button" wire:click="$set('selectedProductId', null)" class="inline-block align-baseline font-bold text-sm text-red-600 hover:text-red-800">
                                    Cancel
                                </button>
                            </div>
                        @else
                            <div class="p-4 bg-gray-50 rounded text-center text-gray-600">
                                <p>Please select a product to adjust stock</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    document.getElementById('scanner-status').innerText = "✓ Barcode: " + result.text;

                    // Dispatch to Livewire component with the barcode
                    if (window.Livewire) {
                        Livewire.dispatch('barcodeDetected', { barcode: result.text });
                        console.log("Event dispatched!");
                    } else {
                        console.warn("Livewire not available yet");
                    }

                    // Stop scanner after successful scan
                    stopZXingScanner();
                }

                if (error && error.name !== 'NotFoundException') {
                    console.warn("Decode error:", error.name, error.message);
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

    if (status) {
        status.innerText = "Scanner stopped.";
    }
}

// Auto-stop on Livewire navigation or page unload
document.addEventListener('livewire:navigated', stopZXingScanner);
window.addEventListener('beforeunload', stopZXingScanner);
</script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            const barcodeInput = document.getElementById('barcodeInput');
            if (barcodeInput) {
                barcodeInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        @this.searchByBarcode();
                    }
                });
            }

            // Listen for stopScanner event
            Livewire.on('stopScanner', () => {
                stopZXingScanner();
            });
        });
    </script>
@endpush
</div>
