<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $type = 'success';
    public $message = '';
    public $visible = false;

    protected $listeners = ['toast'];

    public function toast($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
        $this->visible = true;
        
        // Auto-hide after 5 seconds
        $this->dispatch('hideToastAfterDelay');
    }

    public function close()
    {
        $this->visible = false;
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
