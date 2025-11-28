<div>
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
                        <div class="mb-6 p-4 border rounded bg-blue-50">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <button type="button" wire:click="toggleVideoScanner" class="inline-flex items-center px-4 py-2 {{ $useVideoScanner ? 'bg-red-500 hover:bg-red-600' : 'bg-purple-500 hover:bg-purple-600' }} border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:shadow-outline disabled:opacity-25 transition ease-in-out duration-150">
                                    {{ $useVideoScanner ? '✓ Camera Scanner Active' : '📷 Camera Scanner' }}
                                </button>
                            </div>

                            @if($useVideoScanner)
                                <!-- Video Scanner Section -->
                                <div class="mb-4 p-3 border-2 border-purple-300 rounded bg-purple-50" wire:ignore>
                                    <video id="qr-video" width="100%" height="300" class="border rounded bg-black"></video>
                                    <div id="scanner-status" class="mt-3 text-center text-gray-700 font-bold">📷 Camera active. Point at barcode...</div>
                                    <div class="flex gap-2 justify-center mt-3">
                                        <button type="button" onclick="startZXingScanner()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">Start Scanner</button>
                                        <button type="button" onclick="stopZXingScanner()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">Stop Scanner</button>
                                    </div>
                                </div>
                            @elseif($showManualInput)
                                <div class="mb-4">
                                    <label for="barcodeInput" class="block text-gray-700 text-sm font-bold mb-2">Scan or Enter Barcode/SKU:</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="barcodeInput" wire:model="barcodeInput" placeholder="Point camera here or type barcode/SKU..." autofocus class="shadow appearance-none border rounded flex-1 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        <button type="button" wire:click="searchByBarcode" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            @else
                                <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Search Product (Manual):</label>
                                <input type="text" id="search" wire:model.live="search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search by name, SKU or barcode">
                                @error('selectedProductId') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                                @if(!empty($search) && empty($selectedProduct) && count($products) > 0)
                                    <ul class="border border-gray-300 rounded mt-2 max-h-48 overflow-y-scroll bg-white">
                                        @foreach($products as $product)
                                            <li wire:click="selectProduct({{ $product->id }})" class="p-2 cursor-pointer hover:bg-gray-200 flex justify-between">
                                                <span>{{ $product->name }} (SKU: {{ $product->sku }})</span>
                                                <span class="text-gray-600">Stock: {{ $product->current_stock }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
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
                    Livewire.dispatch('barcodeDetected', { barcode: result.text });
                    console.log("Event dispatched!");
                    
                    // Keep camera running
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
        });
    </script>
@endpush
