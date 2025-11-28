<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class SupplierList extends Component
{
    use WithPagination;

    public $search = '';

    #[On('supplier-updated', 'supplier-created')]
    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('contact_person', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('phone', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.supplier.supplier-list', [
            'suppliers' => $suppliers,
        ]);
    }

    public function delete($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        session()->flash('message', 'Supplier deleted successfully.');
    }
}
