<?php

namespace App\Livewire\Category;

use App\Models\Category;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class CategoryList extends Component
{
    use WithPagination;

    public $viewMode = 'table'; // 'table', 'card'

    #[On('category-updated', 'category-created')]
    public function render()
    {
        // Get inventory ID from session (stored at login)
        $inventoryId = AuthHelper::inventory();

        return view('livewire.category.category-list', [
            'categories' => Category::with(['inventory', 'products'])->where('inventory_id', $inventoryId)->paginate(10),
        ]);
    }

    public function toggleView()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'card' : 'table';
    }

    public function delete($id)
    {
        $inventoryId = AuthHelper::inventory();
        $category = Category::where('inventory_id', $inventoryId)->findOrFail($id);
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }
}
