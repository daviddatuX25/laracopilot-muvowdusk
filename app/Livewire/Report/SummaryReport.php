<?php

namespace App\Livewire\Report;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;
use PDF; // Import the PDF facade
use Illuminate\Support\Facades\DB; // Import the DB facade

class SummaryReport extends Component
{
    public $totalProducts;
    public $totalCategories;
    public $totalSuppliers;
    public $totalStockValue;

    public function mount()
    {
        $this->loadSummaryData();
    }

    public function loadSummaryData()
    {
        $this->totalProducts = Product::count();
        $this->totalCategories = Category::count();
        $this->totalSuppliers = Supplier::count();
        $this->totalStockValue = Product::sum(DB::raw('current_stock * selling_price')); // Assuming selling_price for value
    }

    public function exportPdf()
    {
        $data = [
            'totalProducts' => $this->totalProducts,
            'totalCategories' => $this->totalCategories,
            'totalSuppliers' => $this->totalSuppliers,
            'totalStockValue' => $this->totalStockValue,
        ];

        $pdf = PDF::loadView('reports.summary_pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'summary_report.pdf');
    }

    public function render()
    {
        return view('livewire.report.summary-report');
    }
}
