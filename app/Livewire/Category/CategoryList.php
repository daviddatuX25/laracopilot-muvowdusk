<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CategoryList extends Component
{
    use WithPagination;

    #[On('category-updated', 'category-created')]
    public function render()
    {
        return view('livewire.category.category-list', [
            'categories' => Category::paginate(10),
        ]);
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }
}
