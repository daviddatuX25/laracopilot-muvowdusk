<?php

namespace App\Livewire\Report;

use App\Models\StockMovement;
use Livewire\Component;
use Livewire\WithPagination;

class MovementHistoryReport extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = '';
    public $startDate = '';
    public $endDate = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
    ];

    private function getBaseQuery()
    {
        $query = StockMovement::with('product');

        if (!empty($this->search)) {
            $query->whereHas('product', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->filterType)) {
            $query->where('type', $this->filterType);
        }

        if (!empty($this->startDate)) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if (!empty($this->endDate)) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query;
    }

    public function getMovementHistory()
    {
        return $this->getBaseQuery()->latest()->paginate(15);
    }

    public function exportPdf()
    {
        $movements = $this->getBaseQuery()->latest()->get();
        $data = ['movements' => $movements, 'timestamp' => now()];
        return ReportExporter::exportPdf('reports.movement_history_pdf', $data, 'movement_history_' . now()->format('Y-m-d_Hi') . '.pdf');
    }

    public function exportCsv()
    {
        $movements = $this->getBaseQuery()->latest()->get();

        $headers = ['Date', 'Time', 'Product', 'SKU', 'Type', 'Quantity', 'Old Stock', 'New Stock', 'Reason'];
        $rows = $movements->map(fn($m) => [
            'Date' => $m->created_at->format('Y-m-d'),
            'Time' => $m->created_at->format('H:i:s'),
            'Product' => $m->product->name,
            'SKU' => $m->product->sku,
            'Type' => ucfirst($m->type),
            'Quantity' => $m->quantity,
            'Old Stock' => $m->old_stock,
            'New Stock' => $m->new_stock,
            'Reason' => $m->reason ?? '-',
        ])->toArray();

        return ReportExporter::exportCsv($headers, $rows, 'movement_history_' . now()->format('Y-m-d_Hi') . '.csv');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.report.movement-history-report', [
            'movements' => $this->getMovementHistory(),
            'types' => ['in', 'out', 'adjustment'],
        ]);
    }
}
