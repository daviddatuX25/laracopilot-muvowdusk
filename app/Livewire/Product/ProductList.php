<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';

    #[On('product-updated', 'product-created')]
    public function render()
    {
        $products = Product::with(['category', 'supplier'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->orWhere('barcode', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.product.product-list', [
            'products' => $products,
        ]);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        session()->flash('message', 'Product deleted successfully.');
    }
}
