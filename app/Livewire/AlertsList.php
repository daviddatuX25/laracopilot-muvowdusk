<?php

namespace App\Livewire;

use App\Models\Alert;
use Livewire\Component;
use Livewire\WithPagination;

class AlertsList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.alerts-list', [
            'alerts' => Alert::with('product')->where('status', 'pending')->paginate(10),
        ]);
    }

    public function resolveAlert(Alert $alert)
    {
        $alert->status = 'resolved';
        $alert->save();
        session()->flash('message', 'Alert resolved successfully.');
    }
}
