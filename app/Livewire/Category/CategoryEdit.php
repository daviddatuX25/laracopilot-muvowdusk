<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Validation\Rule;

class CategoryEdit extends Component
{
    protected $category;
    public $name;
    public $description;

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($this->category?->id)],
            'description' => 'nullable|string',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatch('category-updated');

        session()->flash('toast_message', 'Category updated successfully.');
        session()->flash('toast_type', 'success');

        return redirect()->route('categories.index', ['time' => time()]);
    }

    public function render()
    {
        return view('livewire.category.category-edit');
    }
}
