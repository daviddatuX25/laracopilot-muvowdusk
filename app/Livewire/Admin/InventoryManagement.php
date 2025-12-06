<?php

namespace App\Livewire\Admin;

use App\Models\Inventory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class InventoryManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'table';
    public $showForm = false;
    public $editingInventoryId = null;

    public $name = '';
    public $description = '';
    public $location = '';
    public $status = 'active';

    public function render()
    {
        $inventories = Inventory::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('location', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.inventory-management', [
            'inventories' => $inventories,
        ]);
    }

    public function toggleView()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'card' : 'table';
        $this->dispatch('viewModeChanged', mode: $this->viewMode);
    }

    public function openForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->location = '';
        $this->status = 'active';
        $this->editingInventoryId = null;
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        $this->editingInventoryId = $id;
        $this->name = $inventory->name;
        $this->description = $inventory->description;
        $this->location = $inventory->location;
        $this->status = $inventory->status;
        $this->showForm = true;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|unique:inventories,name' . ($this->editingInventoryId ? ',' . $this->editingInventoryId : ''),
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($this->editingInventoryId) {
            Inventory::findOrFail($this->editingInventoryId)->update($validated);
            session()->flash('message', 'Inventory updated successfully.');
        } else {
            Inventory::create($validated);
            session()->flash('message', 'Inventory created successfully.');
        }

        $this->closeForm();
    }

    public function delete($id)
    {
        Inventory::findOrFail($id)->delete();
        session()->flash('message', 'Inventory deleted successfully.');
    }
}
