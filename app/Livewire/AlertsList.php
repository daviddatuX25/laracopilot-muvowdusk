<?php

namespace App\Livewire;

use App\Models\Alert;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class AlertsList extends Component
{
    use WithPagination;

    public $viewMode = 'table';

    public function toggleView()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'card' : 'table';
    }

    #[On('public')]
    public function refreshAlerts()
    {
        // This will trigger a refresh of the alerts
    }

    public function render()
    {
        $inventoryId = AuthHelper::inventory();

        return view('livewire.alerts-list', [
            'alerts' => Alert::with('product')
                ->whereHas('product', function ($q) use ($inventoryId) {
                    $q->where('inventory_id', $inventoryId);
                })
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(10),
            'totalPending' => Alert::whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })->where('status', 'pending')->count(),
        ]);
    }

    public function resolveAlert(Alert $alert)
    {
        $alert->status = 'resolved';
        $alert->resolved_at = now();
        $alert->save();
        session()->flash('message', 'Alert resolved successfully.');
        $this->dispatch('alert-resolved');
    }

    public function markAsSeen(Alert $alert)
    {
        $alert->markAsSeen();
        session()->flash('message', 'Alert marked as seen.');
    }
}
