<?php

namespace App\Livewire\Report;

use App\Models\StockMovement;
use Livewire\Component;
use Livewire\WithPagination;
use PDF; // Import the PDF facade

class MovementHistoryReport extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $startDate = '';
    public $endDate = '';

    public function getMovementHistory()
    {
        $query = StockMovement::with('product')
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->latest();

        return $query->paginate(10);
    }

    public function exportPdf()
    {
        $movements = StockMovement::with('product')
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->startDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->latest()
            ->get();

        $data = ['movements' => $movements];
        $pdf = PDF::loadView('reports.movement_history_pdf', $data);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'movement_history_report.pdf');
    }

    public function render()
    {
        return view('livewire.report.movement-history-report', [
            'movements' => $this->getMovementHistory(),
        ]);
    }
}
