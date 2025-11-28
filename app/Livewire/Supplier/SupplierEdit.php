<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Validation\Rule;

class SupplierEdit extends Component
{
    protected $supplier;
    public $name;
    public $contact_person;
    public $email;
    public $phone;
    public $address;

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->name = $supplier->name;
        $this->contact_person = $supplier->contact_person;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->address = $supplier->address;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('suppliers')->ignore($this->supplier?->id)],
            'contact_person' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('suppliers')->ignore($this->supplier?->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->supplier->update([
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->dispatch('supplier-updated');

        session()->flash('message', 'Supplier updated successfully.');

        return redirect()->route('suppliers.index', ['time' => time()]);
    }

    public function render()
    {
        return view('livewire.supplier.supplier-edit');
    }
}
