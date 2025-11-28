<?php

namespace App\Livewire\Report;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use PDF; // Import the PDF facade

class LowStockReport extends Component
{
    use WithPagination;

    public function getLowStockProducts()
    {
        return Product::with(['category', 'supplier'])
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->orderBy('current_stock')
            ->paginate(10);
    }

    public function exportPdf()
    {
        $products = Product::with(['category', 'supplier'])
            ->whereColumn('current_stock', '<=', 'reorder_level')
            ->orderBy('current_stock')
            ->get();

        $data = ['products' => $products];
        $pdf = PDF::loadView('reports.low_stock_pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'low_stock_report.pdf');
    }

    public function render()
    {
        return view('livewire.report.low-stock-report', [
            'products' => $this->getLowStockProducts(),
        ]);
    }
}
