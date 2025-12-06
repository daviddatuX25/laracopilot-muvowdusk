<?php

namespace App\Livewire;

use App\Models\Product;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\Attributes\On;

class ProductLookup extends Component
{
    public $searchQuery = '';
    public $manualBarcode = '';
    public $foundProductData = [];
    public $notFound = false;
    public $barcodeForCreate = '';
    public $showManualInput = false;

    /**
     * Fired by the ZXing scanner:
     * Livewire.dispatch('searchProductByBarcode', { barcode: "VALUE" })
     */
    #[On('searchProductByBarcode')]
    public function searchProductByBarcode($barcode = null)
    {
        // Handle both array and string parameters
        if (is_array($barcode)) {
            $barcode = $barcode['barcode'] ?? null;
        }

        if (!$barcode) {
            session()->flash('error', 'Invalid scan result');
            return;
        }

        $inventoryId = AuthHelper::inventory();
        $this->searchQuery = $barcode;
        $this->foundProductData = [];
        $this->notFound = false;

        $product = Product::where('inventory_id', $inventoryId)
            ->where(function ($q) use ($barcode) {
                $q->where('barcode', $barcode)
                  ->orWhere('sku', $barcode);
            })
            ->with(['category', 'supplier', 'inventory'])
            ->first();

        if (!$product) {
            $this->notFound = true;
            $this->barcodeForCreate = $barcode;
            session()->flash('error', 'Product not found: ' . $barcode);
        } else {
            $this->foundProductData = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'current_stock' => $product->current_stock,
                'reorder_level' => $product->reorder_level,
                'category_name' => $product->category->name ?? 'N/A',
                'supplier_name' => $product->supplier->name ?? 'N/A',
            ];
            session()->flash('success', 'Product found: ' . $product->name);
        }
    }

    public function searchManualBarcode()
    {
        if (empty($this->manualBarcode)) {
            return;
        }

        // Use the same search logic
        $this->searchProductByBarcode(['barcode' => $this->manualBarcode]);
    }

    public function searchByQuery()
    {
        if (empty($this->searchQuery)) {
            return;
        }

        $inventoryId = AuthHelper::inventory();
        $this->foundProductData = [];
        $this->notFound = false;

        $product = Product::where('inventory_id', $inventoryId)
            ->where(function ($q) {
                $q->where('barcode', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('sku', 'like', '%' . $this->searchQuery . '%')
                  ->orWhere('name', 'like', '%' . $this->searchQuery . '%');
            })
            ->with('category', 'supplier')
            ->first();

        if (!$product) {
            $this->notFound = true;
            $this->barcodeForCreate = $this->searchQuery;
        } else {
            $this->foundProductData = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
                'current_stock' => $product->current_stock,
                'reorder_level' => $product->reorder_level,
                'category_name' => $product->category->name ?? 'N/A',
                'supplier_name' => $product->supplier->name ?? 'N/A',
            ];
        }
    }

    public function toggleManualInput()
    {
        $this->showManualInput = !$this->showManualInput;
        $this->clearSearch();
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->manualBarcode = '';
        $this->foundProductData = [];
        $this->notFound = false;
        $this->barcodeForCreate = '';
        session()->forget('error');
        session()->forget('success');
    }

    public function render()
    {
        return view('livewire.product-lookup');
    }
}
