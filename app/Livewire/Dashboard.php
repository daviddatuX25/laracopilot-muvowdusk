<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Alert;
use App\Models\StockMovement;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function markAlertAsSeen($alertId)
    {
        $alert = Alert::find($alertId);
        if ($alert) {
            $alert->markAsSeen();
        }
    }

    public function render()
    {
        // Get key metrics
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();

        // Low stock products (current_stock <= reorder_level)
        $lowStockProducts = Product::whereRaw('current_stock <= reorder_level')->count();
        $outOfStockProducts = Product::where('current_stock', 0)->count();

        // Alerts
        $activeAlerts = Alert::where('status', 'unresolved')->count();
        $urgentAlerts = Alert::where('type', 'out_of_stock')
            ->where('status', 'unresolved')
            ->count();

        // Recent stock movements
        $recentMovements = StockMovement::with('product')
            ->latest()
            ->limit(10)
            ->get();

        // Low stock products details
        $lowStockList = Product::whereRaw('current_stock <= reorder_level')
            ->with('category', 'supplier')
            ->orderBy('current_stock')
            ->limit(8)
            ->get();

        // Unresolved alerts
        $unresolvedAlerts = Alert::where('status', 'unresolved')
            ->with('product')
            ->latest()
            ->limit(8)
            ->get();

        // Total inventory value (cost)
        $totalInventoryValue = Product::selectRaw('SUM(current_stock * cost_price) as total')
            ->first()
            ->total ?? 0;

        // Calculate total stock quantity
        $totalStockQuantity = Product::sum('current_stock');

        // Top categories by product count
        $topCategories = Category::withCount('products')
            ->orderByDesc('products_count')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'activeAlerts' => $activeAlerts,
            'urgentAlerts' => $urgentAlerts,
            'recentMovements' => $recentMovements,
            'lowStockList' => $lowStockList,
            'unresolvedAlerts' => $unresolvedAlerts,
            'totalInventoryValue' => $totalInventoryValue,
            'totalStockQuantity' => $totalStockQuantity,
            'topCategories' => $topCategories,
        ]);
    }
}
