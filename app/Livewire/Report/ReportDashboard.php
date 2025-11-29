<?php

namespace App\Livewire\Report;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Helpers\AuthHelper;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ReportDashboard extends Component
{
    public function getDashboardStats()
    {
        $inventoryId = AuthHelper::inventory();

        return [
            'total_products' => Product::where('inventory_id', $inventoryId)->count(),
            'total_categories' => Category::where('inventory_id', $inventoryId)->count(),
            'total_suppliers' => Supplier::where('inventory_id', $inventoryId)->count(),
            'total_stock_value' => Product::where('inventory_id', $inventoryId)->sum(DB::raw('current_stock * cost_price')),
            'total_stock_units' => Product::where('inventory_id', $inventoryId)->sum('current_stock'),
            'low_stock_count' => Product::where('inventory_id', $inventoryId)->whereColumn('current_stock', '<=', 'reorder_level')
                ->where('current_stock', '>', 0)
                ->count(),
            'out_of_stock_count' => Product::where('inventory_id', $inventoryId)->where('current_stock', '<=', 0)->count(),
            'normal_stock_count' => Product::where('inventory_id', $inventoryId)->where('current_stock', '>', 0)
                ->whereRaw('current_stock > reorder_level')
                ->count(),
        ];
    }

    public function render()
    {
        return view('livewire.report.report-dashboard', [
            'stats' => $this->getDashboardStats(),
        ]);
    }
}
