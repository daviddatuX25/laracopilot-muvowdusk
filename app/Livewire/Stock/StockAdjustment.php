<?php

namespace App\Livewire\Stock;

use App\Models\Alert;
use App\Models\Product;
use App\Models\StockMovement;
use App\Helpers\AuthHelper;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class StockAdjustment extends Component
{
    public $search = '';
    public $products = [];
    public $selectedProductId;
    public $selectedProductData = [];
    public $quantity = '';
    public $reason;
    public $presetQuantities = [1, 5, 10];
    public $customQuantity = null;

    public function mount()
    {
        // Check if product_id is passed as query parameter from product lookup
        $productId = request()->query('product_id');
        if ($productId) {
            $inventoryId = AuthHelper::inventory();
            $product = Product::where('inventory_id', $inventoryId)->find($productId);
            if ($product) {
                $this->selectProduct($productId);
            }
        }
    }

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->products = [];
            return;
        }

        // Clear selected product if user is searching for a new one
        if (!empty($this->search) && !empty($this->selectedProductData) &&
            !str_contains(strtolower($this->selectedProductData['name'] ?? ''), strtolower($this->search)) &&
            !str_contains($this->selectedProductData['sku'] ?? '', $this->search) &&
            !str_contains($this->selectedProductData['barcode'] ?? '', $this->search ?? '')) {
            $this->selectedProductId = null;
            $this->selectedProductData = [];
        }

        $inventoryId = AuthHelper::inventory();
        $products = Product::where('inventory_id', $inventoryId)
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhere('barcode', 'like', '%' . $this->search . '%');
            })
            ->limit(10)
            ->get();

        // Convert to arrays for serialization
        $this->products = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'sku' => $p->sku,
                'current_stock' => $p->current_stock,
            ];
        })->toArray();

        // Auto-select on exact match
        $this->checkForExactMatch();
    }

    public function checkForExactMatch()
    {
        // Only run if there's actual search input and products exist
        // Skip if search is being cleared (empty)
        if (empty($this->search) || empty($this->products)) {
            return;
        }

        // Check for exact match on barcode or SKU
        foreach ($this->products as $product) {
            if (strtolower($product['barcode'] ?? '') === strtolower($this->search) ||
                strtolower($product['sku'] ?? '') === strtolower($this->search)) {
                // Exact match found, auto-select it (show toast for auto-select)
                $this->selectProduct($product['id']);
                return;
            }
        }
    }

    public function searchBarcodeInput()
    {
        if (!$this->barcodeInput) {
            $this->dispatch('toast', type: 'error', message: 'Please enter a barcode.');
            return;
        }

        $inventoryId = AuthHelper::inventory();
        $product = Product::where('inventory_id', $inventoryId)
            ->where(function ($q) {
                $q->where('barcode', $this->barcodeInput)
                  ->orWhere('sku', $this->barcodeInput);
            })
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
        $inventoryId = AuthHelper::inventory();
        $product = Product::where('inventory_id', $inventoryId)->find($productId);

        if ($product) {
            $this->selectedProductId = $productId;
            $this->selectedProductData = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'current_stock' => $product->current_stock,
                'reorder_level' => $product->reorder_level,
                'category_name' => $product->category->name ?? 'N/A',
            ];
            $this->search = $product->name;
            $this->products = [];

            // Dispatch success toast
            $this->dispatch('toast', type: 'success', message: 'Product loaded: ' . $product->name);
        }
    }    public function clearProductSelection()
    {
        $this->selectedProductId = null;
        $this->selectedProductData = [];
        $this->search = '';
        $this->products = [];
        $this->quantity = '';
        $this->reason = '';
        $this->customQuantity = null;
    }

    #[On('barcodeDetected')]
    public function searchBarcodeFromScanner($barcode = null)
    {
        // Handle both array and string parameters
        if (is_array($barcode)) {
            $barcode = $barcode['barcode'] ?? null;
        }

        if (!$barcode) {
            $this->dispatch('toast', type: 'error', message: 'Invalid barcode');
            return;
        }

        $inventoryId = AuthHelper::inventory();
        $product = Product::where('inventory_id', $inventoryId)
            ->where(function ($q) use ($barcode) {
                $q->where('barcode', $barcode)
                  ->orWhere('sku', $barcode);
            })
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

    public function addQuantity($amount)
    {
        $this->quantity = ($this->quantity ?: 0) + $amount;
        $this->customQuantity = null;
    }

    public function subtractQuantity($amount)
    {
        $this->quantity = ($this->quantity ?: 0) - $amount;
        $this->customQuantity = null;
    }

    public function resetQuantity()
    {
        $this->quantity = '';
        $this->customQuantity = null;
    }

    public function updateCustomQuantity()
    {
        if ($this->customQuantity !== null && $this->customQuantity !== '') {
            $this->quantity = (int) $this->customQuantity;
        }
    }

    public function adjustStock()
    {
        // Validate that we have required data
        if (!$this->selectedProductId) {
            session()->flash('error', 'Please select a product');
            return;
        }

        if ($this->quantity === '' || $this->quantity === null || (int)$this->quantity === 0) {
            session()->flash('error', 'Please select a quantity (cannot be 0)');
            return;
        }

        // Cast quantity to integer
        $this->quantity = (int) $this->quantity;

        // Verify product exists
        $inventoryId = AuthHelper::inventory();
        $product = Product::where('inventory_id', $inventoryId)->find($this->selectedProductId);
        if (!$product) {
            session()->flash('error', 'Product not found');
            return;
        }

        $oldStock = $product->current_stock;

        // Auto-detect type: positive = in, negative = out
        $type = $this->quantity > 0 ? 'in' : 'out';
        $amount = abs($this->quantity);
        $newStock = $type === 'in' ? $oldStock + $amount : $oldStock - $amount;

        if ($newStock < 0) {
            session()->flash('error', 'Cannot set stock to negative. Current stock: ' . $oldStock);
            return;
        }

        DB::beginTransaction();
        try {
            $product->current_stock = $newStock;
            $product->save();

            StockMovement::create([
                'product_id' => $product->id,
                'type' => $type,
                'quantity' => $amount,
                'old_stock' => $oldStock,
                'new_stock' => $newStock,
                'reason' => $this->reason,
            ]);

            $this->checkAndCreateAlerts($product);

            DB::commit();

            $this->reset(['search', 'selectedProductId', 'selectedProductData', 'quantity', 'reason', 'customQuantity']);

            // Dispatch success AFTER reset to avoid validation error showing
            $this->dispatch('toast', type: 'success', message: 'Stock adjusted successfully!');
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
