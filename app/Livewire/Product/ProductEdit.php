<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $productId;
    public $name;
    public $sku;
    public $barcode;
    public $category_id;
    public $supplier_id;
    public $description;
    public $cost_price;
    public $selling_price;
    public $reorder_level;
    public $current_stock;
    public $image;
    public $old_image_path;

    public function mount(Product $product)
    {
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->barcode = $product->barcode;
        $this->category_id = $product->category_id;
        $this->supplier_id = $product->supplier_id;
        $this->description = $product->description;
        $this->cost_price = $product->cost_price;
        $this->selling_price = $product->selling_price;
        $this->reorder_level = $product->reorder_level;
        $this->current_stock = $product->current_stock;
        $this->old_image_path = $product->image_path;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50',
            'barcode' => 'nullable|string|max:50',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
            'current_stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function update()
    {
        // Convert empty strings to null before validation
        if ($this->category_id === '') {
            $this->category_id = null;
        }
        if ($this->supplier_id === '') {
            $this->supplier_id = null;
        }
        if ($this->barcode === '') {
            $this->barcode = null;
        }
        if ($this->description === '') {
            $this->description = null;
        }

        $this->validate();

        try {
            $response = $this->callUpdateEndpoint([
                'name' => $this->name,
                'sku' => $this->sku,
                'barcode' => $this->barcode,
                'category_id' => $this->category_id,
                'supplier_id' => $this->supplier_id,
                'description' => $this->description,
                'cost_price' => $this->cost_price,
                'selling_price' => $this->selling_price,
                'reorder_level' => $this->reorder_level,
                'current_stock' => $this->current_stock,
            ]);

            if ($response['success']) {
                $this->dispatch('product-updated');
                session()->flash('message', 'Product updated successfully.');
                return redirect()->route('products.index', ['time' => time()]);
            } else {
                session()->flash('error', $response['message'] ?? 'Failed to update product.');
                return back();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update product: ' . $e->getMessage());
            return back();
        }
    }

    private function callUpdateEndpoint($data)
    {
        // For now, handle the update locally with proper validation
        $inventoryId = AuthHelper::inventory();
        $product = Product::where('inventory_id', $inventoryId)->findOrFail($this->productId);

        // Validate unique constraints at the database level
        $sku_exists = Product::where('inventory_id', $inventoryId)
            ->where('sku', $this->sku)
            ->where('id', '!=', $this->productId)
            ->exists();

        if ($sku_exists) {
            return ['success' => false, 'message' => 'SKU already exists'];
        }

        $barcode_exists = Product::where('inventory_id', $inventoryId)
            ->where('barcode', $this->barcode)
            ->where('id', '!=', $this->productId)
            ->where('barcode', '!=', null)
            ->exists();

        if ($barcode_exists) {
            return ['success' => false, 'message' => 'Barcode already exists'];
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $product->update($data);

            if ($this->image) {
                if ($this->old_image_path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($this->old_image_path);
                }
                $path = $this->image->store('product_images', 'public');
                $product->image_path = $path;
                $product->save();
            }

            \Illuminate\Support\Facades\DB::commit();
            return ['success' => true];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            throw $e;
        }
    }

    public function render()
    {
        $inventoryId = AuthHelper::inventory();

        return view('livewire.product.product-edit', [
            'categories' => Category::with('inventory')->where('inventory_id', $inventoryId)->get(),
            'suppliers' => Supplier::with('inventory')->where('inventory_id', $inventoryId)->get(),
        ]);
    }
}
