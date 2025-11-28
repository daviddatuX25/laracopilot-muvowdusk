<?php

namespace App\Livewire\Supplier;

use App\Models\Supplier;
use Livewire\Component;

class SupplierCreate extends Component
{
    public $name;
    public $contact_person;
    public $email;
    public $phone;
    public $address;

    protected $rules = [
        'name' => 'required|string|max:255|unique:suppliers',
        'contact_person' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255|unique:suppliers',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Supplier::create([
            'name' => $this->name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->dispatch('supplier-created');

        session()->flash('message', 'Supplier created successfully.');

        return redirect()->route('suppliers.index', ['time' => time()]);
    }

    public function render()
    {
        return view('livewire.supplier.supplier-create');
    }
}
