<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;

class BarcodeScanner extends Component
{
    public $scannedBarcode = '';
    public $manualBarcode = '';
    public $foundProduct = null;
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

        $this->scannedBarcode = $barcode;

        $this->foundProduct = Product::where('barcode', $barcode)
            ->orWhere('sku', $barcode)
            ->first();

        if (!$this->foundProduct) {
            session()->flash('error', 'Product not found: ' . $barcode);
        } else {
            session()->flash('success', 'Product found: ' . $this->foundProduct->name);
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
        $this->foundProduct = null;

        session()->forget('error');
        session()->forget('success');
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
