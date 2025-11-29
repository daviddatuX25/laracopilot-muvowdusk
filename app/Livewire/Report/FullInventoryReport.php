<?php

namespace App\Livewire\Report;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class FullInventoryReport extends Component
{
    use WithPagination, BaseReportTrait;

    public $filterStockStatus = '';
    public $showModal = false;
    public $modalProduct = null;
    public $modalMovements = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterSupplier' => ['except' => ''],
        'filterStockStatus' => ['except' => ''],
    ];

    public function updatedFilterStockStatus()
    {
        $this->resetPage();
    }

    private function getBaseQuery()
    {
        $inventoryId = AuthHelper::inventory();
        $query = Product::with(['category', 'supplier', 'inventory'])
            ->where('inventory_id', $inventoryId);

        $query = $this->applySearchFilter($query, ['name', 'sku', 'barcode']);
        $query = $this->applyCategoryFilter($query);
        $query = $this->applySupplierFilter($query);

        if ($this->filterStockStatus === 'low') {
            $query->whereRaw('current_stock <= reorder_level AND current_stock > 0');
        } elseif ($this->filterStockStatus === 'out') {
            $query->where('current_stock', '<=', 0);
        } elseif ($this->filterStockStatus === 'normal') {
            $query->where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level');
        }

        return $query;
    }

    public function exportPdf()
    {
        $products = $this->getBaseQuery()->get();
        $totalProducts = $products->count();
        $totalStock = $products->sum('current_stock');
        $totalValue = $products->sum(fn($p) => $p->current_stock * $p->cost_price);

        $data = [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalValue' => $totalValue,
            'timestamp' => now(),
        ];

        return ReportExporter::exportPdf('reports.full_inventory_pdf', $data, 'inventory_' . now()->format('Y-m-d_Hi') . '.pdf');
    }

    public function exportCsv()
    {
        $products = $this->getBaseQuery()->get();

        $headers = ['Product Name', 'SKU', 'Barcode', 'Category', 'Supplier', 'Cost Price', 'Selling Price', 'Current Stock', 'Reorder Level', 'Total Value', 'Status'];
        $rows = $products->map(fn($p) => [
            'Product Name' => $p->name,
            'SKU' => $p->sku,
            'Barcode' => $p->barcode ?? '',
            'Category' => $p->category?->name ?? 'N/A',
            'Supplier' => $p->supplier?->name ?? 'N/A',
            'Cost Price' => '₱' . number_format($p->cost_price, 2),
            'Selling Price' => '₱' . number_format($p->selling_price, 2),
            'Current Stock' => $p->current_stock,
            'Reorder Level' => $p->reorder_level,
            'Total Value' => '₱' . number_format($p->current_stock * $p->cost_price, 2),
            'Status' => $p->current_stock <= 0 ? 'Out of Stock' : ($p->current_stock <= $p->reorder_level ? 'Low Stock' : 'Normal'),
        ])->toArray();

        return ReportExporter::exportCsv($headers, $rows, 'inventory_' . now()->format('Y-m-d_Hi') . '.csv');
    }

    public function showProductModal($productId)
    {
        $inventoryId = AuthHelper::inventory();
        $this->modalProduct = Product::where('inventory_id', $inventoryId)->with(['category', 'supplier'])->find($productId);
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

    public function render()
    {
        $inventoryId = AuthHelper::inventory();

        $products = $this->getBaseQuery()->paginate($this->perPage);
        $totalProducts = $this->getBaseQuery()->count();
        $totalStock = $this->getBaseQuery()->sum('current_stock');
        $totalValue = $this->getBaseQuery()->selectRaw('SUM(current_stock * cost_price) as total')->first()->total ?? 0;

        // Get category stats with proper total value calculation
        $categoryStats = Category::where('inventory_id', $inventoryId)->withCount('products')
            ->withSum('products', 'current_stock')
            ->get()
            ->map(function($category) {
                $totalCost = $category->products->sum(fn($p) => $p->current_stock * $p->cost_price);
                $category->products_sum_total_cost = $totalCost;
                return $category;
            })
            ->sortBy('name');

        // Get supplier stats with proper total value calculation
        $supplierStats = Supplier::where('inventory_id', $inventoryId)->withCount('products')
            ->withSum('products', 'current_stock')
            ->get()
            ->map(function($supplier) {
                $totalCost = $supplier->products->sum(fn($p) => $p->current_stock * $p->cost_price);
                $supplier->products_sum_total_cost = $totalCost;
                return $supplier;
            })
            ->sortBy('name');

        $stockStatus = [
            'normal' => Product::where('inventory_id', $inventoryId)->where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level')->count(),
            'low' => Product::where('inventory_id', $inventoryId)->whereRaw('current_stock <= reorder_level AND current_stock > 0')->count(),
            'out' => Product::where('inventory_id', $inventoryId)->where('current_stock', '<=', 0)->count(),
        ];

        return view('livewire.report.full-inventory-report', [
            'products' => $products,
            'categories' => Category::where('inventory_id', $inventoryId)->orderBy('name')->get(),
            'suppliers' => Supplier::where('inventory_id', $inventoryId)->orderBy('name')->get(),
            'categoryStats' => $categoryStats,
            'supplierStats' => $supplierStats,
            'stockStatus' => $stockStatus,
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalValue' => $totalValue,
        ]);
    }
}
