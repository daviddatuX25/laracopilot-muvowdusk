<?php

namespace App\Livewire\Category;

use App\Models\Category;
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

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
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
