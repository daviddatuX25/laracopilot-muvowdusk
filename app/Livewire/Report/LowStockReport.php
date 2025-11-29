<?php

namespace App\Livewire\Report;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class LowStockReport extends Component
{
    use WithPagination, BaseReportTrait;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterSupplier' => ['except' => ''],
    ];

    public function getLowStockProducts()
    {
        $query = Product::with(['category', 'supplier'])
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->where('current_stock', '>', 0);

        $query = $this->applySearchFilter($query, ['name', 'sku', 'barcode']);
        $query = $this->applyCategoryFilter($query);
        $query = $this->applySupplierFilter($query);

        return $query->orderBy('current_stock')->paginate($this->perPage);
    }

    public function exportPdf()
    {
        $products = Product::with(['category', 'supplier'])
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->where('current_stock', '>', 0)
            ->orderBy('current_stock')
            ->get();

        $data = ['products' => $products, 'timestamp' => now()];
        return ReportExporter::exportPdf('reports.low_stock_pdf', $data, 'low_stock_report_' . now()->format('Y-m-d_Hi') . '.pdf');
    }

    public function exportCsv()
    {
        $products = Product::with(['category', 'supplier'])
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->where('current_stock', '>', 0)
            ->orderBy('current_stock')
            ->get();

        $headers = ['Product Name', 'SKU', 'Barcode', 'Category', 'Supplier', 'Current Stock', 'Reorder Level', 'Deficit'];
        $rows = $products->map(fn($p) => [
            'Product Name' => $p->name,
            'SKU' => $p->sku,
            'Barcode' => $p->barcode ?? '',
            'Category' => $p->category?->name ?? 'N/A',
            'Supplier' => $p->supplier?->name ?? 'N/A',
            'Current Stock' => $p->current_stock,
            'Reorder Level' => $p->reorder_level,
            'Deficit' => $p->reorder_level - $p->current_stock,
        ])->toArray();

        return ReportExporter::exportCsv($headers, $rows, 'low_stock_report_' . now()->format('Y-m-d_Hi') . '.csv');
    }

    public function render()
    {
        return view('livewire.report.low-stock-report', [
            'products' => $this->getLowStockProducts(),
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ]);
    }
}
