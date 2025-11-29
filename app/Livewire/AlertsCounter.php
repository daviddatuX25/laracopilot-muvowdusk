<?php

namespace App\Livewire;

use App\Models\Alert;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\Attributes\On;

class AlertsCounter extends Component
{
    public $pendingCount = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('new-alert')]
    #[On('alert-resolved')]
    public function updateCount()
    {
        $inventoryId = AuthHelper::inventory();
        $this->pendingCount = Alert::where('status', 'pending')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })->count();
    }

    public function render()
    {
        return view('livewire.alerts-counter', [
            'pendingCount' => $this->pendingCount,
        ]);
    }
}
