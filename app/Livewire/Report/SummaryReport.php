<?php

namespace App\Livewire\Report;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
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
        $this->totalProducts = Product::count();
        $this->totalCategories = Category::count();
        $this->totalSuppliers = Supplier::count();
        $this->totalStockValue = Product::sum(DB::raw('current_stock * cost_price'));
        $this->totalStockUnits = Product::sum('current_stock');
        $this->lowStockCount = Product::whereColumn('current_stock', '<=', 'reorder_level')
            ->where('current_stock', '>', 0)->count();
        $this->outOfStockCount = Product::where('current_stock', '<=', 0)->count();
        $this->normalStockCount = Product::where('current_stock', '>', 0)
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
                    ['Metric' => 'Total Stock Value', 'Value' => '$' . number_format($this->totalStockValue, 2)],
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
