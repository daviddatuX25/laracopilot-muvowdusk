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
        $query = Product::with(['category', 'supplier']);

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
            'Cost Price' => number_format($p->cost_price, 2),
            'Selling Price' => number_format($p->selling_price, 2),
            'Current Stock' => $p->current_stock,
            'Reorder Level' => $p->reorder_level,
            'Total Value' => number_format($p->current_stock * $p->cost_price, 2),
            'Status' => $p->current_stock <= 0 ? 'Out of Stock' : ($p->current_stock <= $p->reorder_level ? 'Low Stock' : 'Normal'),
        ])->toArray();

        return ReportExporter::exportCsv($headers, $rows, 'inventory_' . now()->format('Y-m-d_Hi') . '.csv');
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

    public function render()
    {
        $products = $this->getBaseQuery()->paginate($this->perPage);
        $totalProducts = $this->getBaseQuery()->count();
        $totalStock = $this->getBaseQuery()->sum('current_stock');
        $totalValue = $this->getBaseQuery()->selectRaw('SUM(current_stock * cost_price) as total')->first()->total ?? 0;

        $categoryStats = Category::withCount('products')
            ->withSum('products', 'current_stock')
            ->withSum('products as total_cost', DB::raw('current_stock * cost_price'))
            ->orderBy('name')
            ->get();

        $supplierStats = Supplier::withCount('products')
            ->withSum('products', 'current_stock')
            ->withSum('products as total_cost', DB::raw('current_stock * cost_price'))
            ->orderBy('name')
            ->get();

        $stockStatus = [
            'normal' => Product::where('current_stock', '>', 0)->whereRaw('current_stock > reorder_level')->count(),
            'low' => Product::whereRaw('current_stock <= reorder_level AND current_stock > 0')->count(),
            'out' => Product::where('current_stock', '<=', 0)->count(),
        ];

        return view('livewire.report.full-inventory-report', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
            'categoryStats' => $categoryStats,
            'supplierStats' => $supplierStats,
            'stockStatus' => $stockStatus,
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalValue' => $totalValue,
        ]);
    }
}
