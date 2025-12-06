<?php

namespace App\Livewire;

use App\Models\Alert;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\Attributes\On;

class NotificationCenter extends Component
{
    public $notifications = [];
    public $totalCount = 0;
    public $unseenCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    #[On('new-alert')]
    #[On('alert-resolved')]
    #[On('alert-seen')]
    public function loadNotifications()
    {
        $inventoryId = AuthHelper::inventory();

        $alerts = Alert::where('status', 'pending')
            ->with('product')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Convert models to arrays for serialization
        $this->notifications = $alerts->map(function ($alert) {
            return [
                'id' => $alert->id,
                'product_id' => $alert->product_id,
                'product_name' => $alert->product->name ?? 'N/A',
                'type' => $alert->type,
                'message' => $alert->message,
                'status' => $alert->status,
                'seen_at' => $alert->seen_at,
                'created_at' => $alert->created_at,
                'is_seen' => !is_null($alert->seen_at),
                'formatted_age' => $alert->created_at->diffForHumans(),
            ];
        })->toArray();

        $this->totalCount = Alert::where('status', 'pending')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })->count();

        $this->unseenCount = Alert::where('status', 'pending')
            ->whereNull('seen_at')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })
            ->count();
    }

    public function resolveAlert($alertId)
    {
        $alert = Alert::find($alertId);
        if ($alert) {
            $alert->status = 'resolved';
            $alert->resolved_at = now();
            $alert->save();
            $this->loadNotifications();
            $this->dispatch('alert-resolved');
        }
    }

    public function markAsSeen($alertId)
    {
        $alert = Alert::find($alertId);
        if ($alert && !$alert->isSeen()) {
            $alert->update(['seen_at' => now()]);
        }
        // Reload all notifications with fresh data from database
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-center', [
            'notifications' => $this->notifications,
            'totalCount' => $this->totalCount,
            'unseenCount' => $this->unseenCount,
        ]);
    }
}
