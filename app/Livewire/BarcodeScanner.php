<?php

namespace App\Livewire;

use App\Models\Product;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\Attributes\On;

class BarcodeScanner extends Component
{
    public $scannedBarcode = '';
    public $manualBarcode = '';
    public $foundProductData = [];
    public $showManualInput = false;
    public $useCameraScanner = false;

    protected $rules = [
        'manualBarcode' => 'required|string|max:50',
    ];

    /**
     * Fired by the ZXing scanner:
     * Livewire.dispatch('searchProductByBarcode', { barcode: "VALUE" })
     */
    #[On('searchProductByBarcode')]
    public function searchProductByBarcode(array $data = [])
    {
        // ZXing sends: ['barcode' => '12345']
        $barcode = is_array($data) ? ($data['barcode'] ?? null) : $data;

        if (!$barcode) {
            session()->flash('error', 'Invalid scan result');
            return;
        }

        $inventoryId = AuthHelper::inventory();
        $this->scannedBarcode = $barcode;

        $product = Product::where('inventory_id', $inventoryId)
            ->where(function ($q) use ($barcode) {
                $q->where('barcode', $barcode)
                  ->orWhere('sku', $barcode);
            })
            ->first();

        if (!$product) {
            $this->foundProductData = [];
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
            ];
            session()->flash('success', 'Product found: ' . $product->name);
        }
    }

    public function searchManualBarcode()
    {
        $this->validate();
        // Manual also uses the same logic
        $this->searchProductByBarcode(['barcode' => $this->manualBarcode]);
    }

    /**
     * Resets data only — does NOT touch toggles
     */
    public function resetScanner()
    {
        $this->scannedBarcode = '';
        $this->manualBarcode = '';
        $this->foundProductData = [];

        session()->forget('error');
        session()->forget('success');
    }

    /**
     * Clear search state for modal closing
     */
    public function clearSearch()
    {
        $this->resetScanner();
    }

    /**
     * Toggle manual input mode
     */
    public function toggleManualInput()
    {
        $this->showManualInput = !$this->showManualInput;

        // Turn off camera mode when manual mode is selected
        if ($this->showManualInput) {
            $this->useCameraScanner = false;
        }

        $this->resetScanner();
    }

    /**
     * Toggle camera scanner mode
     */
    public function toggleCameraScanner()
    {
        $this->useCameraScanner = !$this->useCameraScanner;

        // Turn off manual input
        if ($this->useCameraScanner) {
            $this->showManualInput = false;
        }

        $this->resetScanner();
    }

    public function render()
    {
        return view('livewire.barcode-scanner');
    }
}
