<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Inventory;
use App\Models\UserInventory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class UserInventoryLink extends Component
{
    use WithPagination;

    public $search = '';
    public $inventorySearch = '';
    public $selectedUserId = null;
    public $selectedInventoryIds = [];

    public function render()
    {
        $users = User::where('userid', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $inventories = Inventory::where('name', 'like', '%' . $this->inventorySearch . '%')
            ->orderBy('name')
            ->get();

        $currentLinks = [];
        if ($this->selectedUserId) {
            $currentLinks = UserInventory::where('user_id', $this->selectedUserId)
                ->pluck('inventory_id')
                ->toArray();
        }

        return view('livewire.admin.user-inventory-link', [
            'users' => $users,
            'inventories' => $inventories,
            'currentLinks' => $currentLinks,
        ]);
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->loadCurrentLinks();
    }

    public function loadCurrentLinks()
    {
        $this->selectedInventoryIds = UserInventory::where('user_id', $this->selectedUserId)
            ->pluck('inventory_id')
            ->toArray();
    }

    public function toggleInventory($inventoryId)
    {
        if (in_array($inventoryId, $this->selectedInventoryIds)) {
            $this->selectedInventoryIds = array_filter(
                $this->selectedInventoryIds,
                fn($id) => $id != $inventoryId
            );
        } else {
            $this->selectedInventoryIds[] = $inventoryId;
        }
    }

    public function saveLinks()
    {
        if (!$this->selectedUserId) {
            session()->flash('error', 'Please select a user first.');
            return;
        }

        // Remove all existing links for this user
        UserInventory::where('user_id', $this->selectedUserId)->delete();

        // Create new links
        foreach ($this->selectedInventoryIds as $inventoryId) {
            UserInventory::create([
                'user_id' => $this->selectedUserId,
                'inventory_id' => $inventoryId,
            ]);
        }

        session()->flash('message', 'User inventory links updated successfully.');
    }
}
