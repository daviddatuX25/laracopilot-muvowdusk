<?php

namespace App\Livewire\Report;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SummaryReport extends Component
{
    public $totalProducts;
    public $totalCategories;
    public $totalSuppliers;
    public $totalStockValue;
    public $totalStockUnits;
    public $lowStockCount;
    public $outOfStockCount;
    public $normalStockCount;

    public function mount()
    {
        $this->loadSummaryData();
    }

    public function loadSummaryData()
    {
        $inventoryId = AuthHelper::inventory();

        $this->totalProducts = Product::where('inventory_id', $inventoryId)->count();
        $this->totalCategories = Category::where('inventory_id', $inventoryId)->count();
        $this->totalSuppliers = Supplier::where('inventory_id', $inventoryId)->count();
        $this->totalStockValue = Product::where('inventory_id', $inventoryId)->sum(DB::raw('current_stock * cost_price'));
        $this->totalStockUnits = Product::where('inventory_id', $inventoryId)->sum('current_stock');
        $this->lowStockCount = Product::where('inventory_id', $inventoryId)->whereColumn('current_stock', '<=', 'reorder_level')
            ->where('current_stock', '>', 0)->count();
        $this->outOfStockCount = Product::where('inventory_id', $inventoryId)->where('current_stock', '<=', 0)->count();
        $this->normalStockCount = Product::where('inventory_id', $inventoryId)->where('current_stock', '>', 0)
            ->whereRaw('current_stock > reorder_level')->count();
    }

    public function exportPdf()
    {
        $data = [
            'totalProducts' => $this->totalProducts,
            'totalCategories' => $this->totalCategories,
            'totalSuppliers' => $this->totalSuppliers,
            'totalStockValue' => $this->totalStockValue,
            'totalStockUnits' => $this->totalStockUnits,
            'lowStockCount' => $this->lowStockCount,
            'outOfStockCount' => $this->outOfStockCount,
            'normalStockCount' => $this->normalStockCount,
            'timestamp' => now(),
        ];

        return ReportExporter::exportPdf('reports.summary_pdf', $data, 'summary_report_' . now()->format('Y-m-d_Hi') . '.pdf');
    }

    public function exportCsv()
    {
        $sections = [
            [
                'title' => 'INVENTORY SUMMARY',
                'headers' => ['Metric', 'Value'],
                'rows' => [
                    ['Metric' => 'Total Products', 'Value' => $this->totalProducts],
                    ['Metric' => 'Total Categories', 'Value' => $this->totalCategories],
                    ['Metric' => 'Total Suppliers', 'Value' => $this->totalSuppliers],
                    ['Metric' => 'Total Stock Units', 'Value' => $this->totalStockUnits],
                    ['Metric' => 'Total Stock Value', 'Value' => '₱' . number_format($this->totalStockValue, 2)],
                ],
            ],
            [
                'title' => 'STOCK STATUS',
                'headers' => ['Status', 'Count'],
                'rows' => [
                    ['Status' => 'Normal Stock', 'Count' => $this->normalStockCount],
                    ['Status' => 'Low Stock', 'Count' => $this->lowStockCount],
                    ['Status' => 'Out of Stock', 'Count' => $this->outOfStockCount],
                ],
            ],
        ];

        return ReportExporter::exportMultiSectionCsv($sections, 'summary_report_' . now()->format('Y-m-d_Hi') . '.csv');
    }

    public function render()
    {
        return view('livewire.report.summary-report');
    }
}
