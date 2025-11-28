<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $sku;
    public $barcode;
    public $category_id;
    public $supplier_id;
    public $description;
    public $cost_price = 0;
    public $selling_price = 0;
    public $reorder_level = 0;
    public $current_stock = 0;
    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:50|unique:products',
        'barcode' => 'nullable|string|max:50|unique:products',
        'category_id' => 'required|exists:categories,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'description' => 'nullable|string',
        'cost_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'reorder_level' => 'required|integer|min:0',
        'current_stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function save()
    {
        $this->validate();

        if (empty($this->barcode)) {
            $this->barcode = $this->generateBarcode();
        }

        DB::beginTransaction();
        try {
            $product = Product::create([
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

            if ($this->image) {
                $path = $this->image->store('product_images', 'public');
                $product->image_path = $path;
                $product->save();
            }

            DB::commit();

            $this->dispatch('product-created');

            session()->flash('message', 'Product created successfully.');

            return redirect()->route('products.index', ['time' => time()]);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create product: ' . $e->getMessage());
            return back();
        }
    }

    private function generateBarcode()
    {
        $barcode = 'BAR' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        while (Product::where('barcode', $barcode)->exists()) {
            $barcode = 'BAR' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        }
        return $barcode;
    }

    public function render()
    {
        return view('livewire.product.product-create', [
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
        ]);
    }
}
