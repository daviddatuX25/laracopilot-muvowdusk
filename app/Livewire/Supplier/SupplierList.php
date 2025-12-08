<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class SupplierList extends Component
{
    use WithPagination;

    public $search = '';
    public $viewMode = 'table'; // 'table', 'card'

    #[On('supplier-updated', 'supplier-created')]
    public function render()
    {
        // Get inventory ID from session (stored at login)
        $inventoryId = AuthHelper::inventory();

        $suppliers = Supplier::where('inventory_id', $inventoryId)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.supplier.supplier-list', [
            'suppliers' => $suppliers,
        ]);
    }

    public function toggleView()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'card' : 'table';
    }

    public function delete($id)
    {
        $inventoryId = AuthHelper::inventory();
        $supplier = Supplier::where('inventory_id', $inventoryId)->findOrFail($id);
        $supplier->delete();
        $this->dispatch('toast', type: 'success', message: 'Supplier deleted successfully.');
    }
}
