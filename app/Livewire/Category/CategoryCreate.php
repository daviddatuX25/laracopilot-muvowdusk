<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Helpers\AuthHelper;
use Livewire\Component;

class CategoryCreate extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255|unique:categories',
        'description' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        // Get inventory ID from session (stored at login)
        $inventoryId = AuthHelper::inventory();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'inventory_id' => $inventoryId,
        ]);

        $this->dispatch('category-created');

        session()->flash('message', 'Category created successfully.');

        return redirect()->route('categories.index', ['time' => time()]);
    }

    public function render()
    {
        return view('livewire.category.category-create');
    }
}
