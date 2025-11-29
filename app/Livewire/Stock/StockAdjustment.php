<?php

namespace App\Livewire\Stock;

use App\Models\Alert;
use App\Models\Product;
use App\Models\StockMovement;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class StockAdjustment extends Component
{
    public $showManualInput = false; // toggle manual input mode
    public $barcodeInput = '';        // input field for manual barcode scan

    public $search = '';
    public $products = [];
    public $selectedProductId;
    public $selectedProduct;
    public $quantity = '';
    public $type = 'in'; // 'in', 'out', 'adjustment'
    public $reason;
    public $useVideoScanner = false; // Camera scanner toggle
    public $presetQuantities = [1, 5, 10];
    public $customQuantity = null;

    protected $rules = [
        'selectedProductId' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'type' => 'required|in:in,out,adjustment',
        'reason' => 'nullable|string|max:255',
    ];

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->products = [];
            return;
        }

        $this->products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->orWhere('barcode', 'like', '%' . $this->search . '%')
            ->limit(10)
            ->get();
    }

    public function searchByBarcode()
    {
        if (!$this->barcodeInput) {
            $this->dispatch('toast', type: 'error', message: 'Please enter a barcode.');
            return;
        }

        $product = Product::where('barcode', $this->barcodeInput)
            ->orWhere('sku', $this->barcodeInput)
            ->first();

        if ($product) {
            $this->selectProduct($product->id);
            $this->dispatch('toast', type: 'success', message: 'Product found: ' . $product->name);
        } else {
            $this->dispatch('toast', type: 'error', message: 'Product not found with barcode: ' . $this->barcodeInput);
        }
    }


    public function selectProduct($productId)
    {
        $this->selectedProductId = $productId;
        $this->selectedProduct = Product::find($productId);
        $this->search = $this->selectedProduct->name;
        $this->products = [];
    }

    public function toggleVideoScanner()
    {
        $this->useVideoScanner = !$this->useVideoScanner;

        // If disabling, dispatch event to stop scanner
        if (!$this->useVideoScanner) {
            $this->dispatch('stopScanner');
        }
    }

    #[On('barcodeDetected')]
    public function handleBarcodeDetected($barcode)
    {
        // Handle both array and string parameters
        if (is_array($barcode)) {
            $barcode = $barcode['barcode'] ?? null;
        }

        if (!$barcode) {
            $this->dispatch('toast', type: 'error', message: 'Invalid barcode');
            return;
        }

        $product = Product::where('barcode', $barcode)
            ->orWhere('sku', $barcode)
            ->first();

        if ($product) {
            $this->selectProduct($product->id);
            $this->dispatch('toast', type: 'success', message: 'Product found: ' . $product->name);
        } else {
            $this->dispatch('toast', type: 'error', message: 'Product not found with barcode: ' . $barcode);
        }
    }

    public function setQuantity($qty)
    {
        $this->quantity = $qty;
        $this->customQuantity = null;
    }

    public function updateCustomQuantity()
    {
        if ($this->customQuantity && $this->customQuantity > 0) {
            $this->quantity = $this->customQuantity;
        }
    }

    public function adjustStock()
    {
        $this->validate();

        $product = Product::find($this->selectedProductId);
        $oldStock = $product->current_stock;
        $newStock = $oldStock;

        DB::beginTransaction();
        try {
            if ($this->type === 'in') {
                $newStock += $this->quantity;
            } elseif ($this->type === 'out') {
                $newStock -= $this->quantity;
            } elseif ($this->type === 'adjustment') {
                if ($this->reason) {
                    $newStock = $this->quantity;
                } else {
                    $newStock += $this->quantity;
                }
            }

            if ($newStock < 0 && !($this->type === 'adjustment' && $this->reason)) {
                DB::rollBack();
                $this->dispatch('toast', type: 'error', message: 'Cannot set stock to negative without a specific reason for manual adjustment.');
                return;
            }

            $product->current_stock = $newStock;
            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'type' => $this->type,
                'quantity' => $this->quantity,
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'reason' => $this->reason,
            ]);

            $this->checkAndCreateAlerts($product);

            DB::commit();
            $this->dispatch('toast', type: 'success', message: 'Stock adjusted successfully.');

            $this->reset(['search', 'selectedProductId', 'selectedProduct', 'quantity', 'type', 'reason', 'customQuantity']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('toast', type: 'error', message: 'Failed to adjust stock: ' . $e->getMessage());
        }
    }

    private function checkAndCreateAlerts(Product $product)
    {
        if ($product->current_stock <= $product->reorder_level && $product->current_stock > 0) {
            $alert = Alert::firstOrCreate(
                ['product_id' => $product->id, 'type' => 'low_stock', 'status' => 'pending'],
                ['message' => 'Product ' . $product->name . ' is running low on stock. Current stock: ' . $product->current_stock . ', Reorder level: ' . $product->reorder_level . '.']
            );
            // Broadcast new alert event
            $this->dispatch('new-alert', type: 'low_stock', productName: $product->name);
        } elseif ($product->current_stock <= 0) {
            $alert = Alert::firstOrCreate(
                ['product_id' => $product->id, 'type' => 'out_of_stock', 'status' => 'pending'],
                ['message' => 'Product ' . $product->name . ' is out of stock.']
            );
            // Broadcast new alert event
            $this->dispatch('new-alert', type: 'out_of_stock', productName: $product->name);
        } else {
            Alert::where('product_id', $product->id)
                ->whereIn('type', ['low_stock', 'out_of_stock'])
                ->where('status', 'pending')
                ->update(['status' => 'resolved']);
        }
    }

    public function render()
    {
        return view('livewire.stock.stock-adjustment');
    }
}
