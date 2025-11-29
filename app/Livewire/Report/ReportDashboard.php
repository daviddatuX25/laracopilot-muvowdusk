<?php

namespace App\Livewire\Report;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ReportDashboard extends Component
{
    public function getDashboardStats()
    {
        return [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_suppliers' => Supplier::count(),
            'total_stock_value' => Product::sum(DB::raw('current_stock * cost_price')),
            'total_stock_units' => Product::sum('current_stock'),
            'low_stock_count' => Product::whereColumn('current_stock', '<=', 'reorder_level')
                ->where('current_stock', '>', 0)
                ->count(),
            'out_of_stock_count' => Product::where('current_stock', '<=', 0)->count(),
            'normal_stock_count' => Product::where('current_stock', '>', 0)
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
