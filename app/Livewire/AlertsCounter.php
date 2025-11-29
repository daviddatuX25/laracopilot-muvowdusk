<?php

namespace App\Livewire;

use App\Models\Alert;
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
        $this->pendingCount = Alert::where('status', 'pending')->count();
    }

    public function render()
    {
        return view('livewire.alerts-counter', [
            'pendingCount' => $this->pendingCount,
        ]);
    }
}
