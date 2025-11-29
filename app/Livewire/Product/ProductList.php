<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'table'; // 'table', 'card'

    #[On('product-updated', 'product-created')]
    public function render()
    {
        // Get inventory ID from session (stored at login)
        $inventoryId = AuthHelper::inventory();

        $products = Product::with(['category', 'supplier', 'inventory'])
            ->where('inventory_id', $inventoryId)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhere('barcode', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.product.product-list', [
            'products' => $products,
        ]);
    }

    public function toggleView()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'card' : 'table';
    }

    public function delete($id)
    {
        $inventoryId = AuthHelper::inventory();
        $product = Product::where('inventory_id', $inventoryId)->findOrFail($id);
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        session()->flash('message', 'Product deleted successfully.');
    }
}
