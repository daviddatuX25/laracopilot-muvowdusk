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

    public $search = '';
    public $viewMode = 'table'; // 'table', 'card'

    #[On('category-updated', 'category-created')]
    public function render()
    {
        // Get inventory ID from session (stored at login)
        $inventoryId = AuthHelper::inventory();

        $categories = Category::with(['inventory', 'products'])
            ->where('inventory_id', $inventoryId)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.category.category-list', [
            'categories' => $categories,
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
        $this->dispatch('toast', type: 'success', message: 'Category deleted successfully.');
    }
}
