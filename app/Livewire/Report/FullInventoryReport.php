<?php

namespace App\Livewire\Report;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class FullInventoryReport extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $filterSupplier = '';
    public $filterStockStatus = ''; // 'all', 'low', 'out', 'normal'
    public $perPage = 50;
    public $showModal = false;
    public $modalProduct = null;
    public $modalMovements = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterSupplier' => ['except' => ''],
        'filterStockStatus' => ['except' => ''],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function updatedFilterSupplier()
    {
        $this->resetPage();
    }

    public function updatedFilterStockStatus()
    {
        $this->resetPage();
    }

    public function exportCsv()
    {
        $query = Product::with(['category', 'supplier']);

        // Apply all same filters as display
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhere('barcode', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }

        if (!empty($this->filterSupplier)) {
            $query->where('supplier_id', $this->filterSupplier);
        }

        if ($this->filterStockStatus === 'low') {
            $query->whereRaw('current_stock <= reorder_level AND current_stock > 0');
        } elseif ($this->filterStockStatus === 'out') {
            $query->where('current_stock', '<=', 0);
        } elseif ($this->filterStockStatus === 'normal') {
            $query->where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level');
        }

        $products = $query->get();

        // Create CSV
        $csv = "Product Name,SKU,Barcode,Category,Supplier,Cost Price,Selling Price,Current Stock,Reorder Level,Total Value,Status\n";

        foreach ($products as $product) {
            $totalValue = $product->current_stock * $product->cost_price;
            $status = $product->current_stock <= 0 ? 'Out of Stock' : ($product->current_stock <= $product->reorder_level ? 'Low Stock' : 'Normal');
            
            $csv .= sprintf(
                '"%s","%s","%s","%s","%s","%.2f","%.2f","%d","%d","%.2f","%s"' . "\n",
                $product->name,
                $product->sku,
                $product->barcode ?? '',
                $product->category?->name ?? 'N/A',
                $product->supplier?->name ?? 'N/A',
                $product->cost_price,
                $product->selling_price,
                $product->current_stock,
                $product->reorder_level,
                $totalValue,
                $status
            );
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'inventory_' . now()->format('Y-m-d_Hi') . '.csv', [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="inventory_' . now()->format('Y-m-d_Hi') . '.csv"',
        ]);
    }

    public function render()
    {
        $query = Product::with(['category', 'supplier']);

        // Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhere('barcode', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }

        // Supplier filter
        if (!empty($this->filterSupplier)) {
            $query->where('supplier_id', $this->filterSupplier);
        }

        // Stock status filter
        if ($this->filterStockStatus === 'low') {
            $query->whereRaw('current_stock <= reorder_level AND current_stock > 0');
        } elseif ($this->filterStockStatus === 'out') {
            $query->where('current_stock', '<=', 0);
        } elseif ($this->filterStockStatus === 'normal') {
            $query->where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level');
        }

        $products = $query->paginate($this->perPage);

        // Calculate totals
        $totalProducts = $query->count();
        $totalStock = $query->sum('current_stock');
        $totalValue = $query->selectRaw('SUM(current_stock * cost_price) as total')->first()->total ?? 0;

        // Get filter options
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        // Get category summaries
        $categoryStats = Category::withCount('products')
            ->withSum('products', 'current_stock')
            ->withSum('products as total_cost', \DB::raw('current_stock * cost_price'))
            ->orderBy('name')
            ->get();

        // Get supplier summaries
        $supplierStats = Supplier::withCount('products')
            ->withSum('products', 'current_stock')
            ->withSum('products as total_cost', \DB::raw('current_stock * cost_price'))
            ->orderBy('name')
            ->get();

        // Get stock status counts
        $stockStatus = [
            'normal' => Product::where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level')->count(),
            'low' => Product::whereRaw('current_stock <= reorder_level AND current_stock > 0')->count(),
            'out' => Product::where('current_stock', '<=', 0)->count(),
        ];

        return view('livewire.report.full-inventory-report', [
            'products' => $products,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'categoryStats' => $categoryStats,
            'supplierStats' => $supplierStats,
            'stockStatus' => $stockStatus,
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalValue' => $totalValue,
        ]);
    }

    public function showProductModal($productId)
    {
        $this->modalProduct = Product::with(['category', 'supplier'])->find($productId);
        $this->modalMovements = \App\Models\StockMovement::where('product_id', $productId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->modalProduct = null;
        $this->modalMovements = [];
    }

    public function exportExcel()
    {
        // Get all data for Excel
        $query = Product::with(['category', 'supplier']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhere('barcode', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }

        if (!empty($this->filterSupplier)) {
            $query->where('supplier_id', $this->filterSupplier);
        }

        if ($this->filterStockStatus === 'low') {
            $query->whereRaw('current_stock <= reorder_level AND current_stock > 0');
        } elseif ($this->filterStockStatus === 'out') {
            $query->where('current_stock', '<=', 0);
        } elseif ($this->filterStockStatus === 'normal') {
            $query->where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level');
        }

        $products = $query->get();
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        $totalProducts = $products->count();
        $totalStock = $products->sum('current_stock');
        $totalValue = $products->sum(fn($p) => $p->current_stock * $p->cost_price);

        // Create Excel-like CSV with multiple sections
        $excel = "INVENTORY REPORT - " . now()->format('Y-m-d H:i:s') . "\n\n";

        // SUMMARY SECTION
        $excel .= "SUMMARY\n";
        $excel .= "Total Products,Total Stock Units,Total Value (Cost)\n";
        $excel .= "$totalProducts,$totalStock," . number_format($totalValue, 2) . "\n\n";

        // STOCK STATUS SECTION
        $normalCount = Product::where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level')->count();
        $lowCount = Product::whereRaw('current_stock <= reorder_level AND current_stock > 0')->count();
        $outCount = Product::where('current_stock', '<=', 0)->count();

        $excel .= "STOCK STATUS BREAKDOWN\n";
        $excel .= "Normal,Low Stock,Out of Stock\n";
        $excel .= "$normalCount,$lowCount,$outCount\n\n";

        // CATEGORY BREAKDOWN
        $excel .= "INVENTORY BY CATEGORY\n";
        $excel .= "Category,Product Count,Total Stock,Total Value\n";
        foreach ($categories as $cat) {
            $catProducts = $products->filter(fn($p) => $p->category_id === $cat->id);
            $catStock = $catProducts->sum('current_stock');
            $catValue = $catProducts->sum(fn($p) => $p->current_stock * $p->cost_price);
            $excel .= "\"{$cat->name}\"," . $catProducts->count() . ",$catStock," . number_format($catValue, 2) . "\n";
        }
        $excel .= "\n";

        // SUPPLIER BREAKDOWN
        $excel .= "INVENTORY BY SUPPLIER\n";
        $excel .= "Supplier,Product Count,Total Stock,Total Value\n";
        foreach ($suppliers as $sup) {
            $supProducts = $products->filter(fn($p) => $p->supplier_id === $sup->id);
            $supStock = $supProducts->sum('current_stock');
            $supValue = $supProducts->sum(fn($p) => $p->current_stock * $p->cost_price);
            $excel .= "\"{$sup->name}\"," . $supProducts->count() . ",$supStock," . number_format($supValue, 2) . "\n";
        }
        $excel .= "\n";

        // DETAILED INVENTORY
        $excel .= "DETAILED INVENTORY\n";
        $excel .= "Product Name,SKU,Barcode,Category,Supplier,Cost Price,Selling Price,Current Stock,Reorder Level,Total Value,Status\n";
        foreach ($products as $product) {
            $totalVal = $product->current_stock * $product->cost_price;
            $status = $product->current_stock <= 0 ? 'Out of Stock' : ($product->current_stock <= $product->reorder_level ? 'Low Stock' : 'Normal');
            $excel .= sprintf(
                '"%s","%s","%s","%s","%s","%.2f","%.2f","%d","%d","%.2f","%s"' . "\n",
                $product->name,
                $product->sku,
                $product->barcode ?? '',
                $product->category?->name ?? 'N/A',
                $product->supplier?->name ?? 'N/A',
                $product->cost_price,
                $product->selling_price,
                $product->current_stock,
                $product->reorder_level,
                $totalVal,
                $status
            );
        }

        return response()->streamDownload(function () use ($excel) {
            echo $excel;
        }, 'inventory_report_' . now()->format('Y-m-d_Hi') . '.csv', [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="inventory_report_' . now()->format('Y-m-d_Hi') . '.csv"',
        ]);
    }
}
