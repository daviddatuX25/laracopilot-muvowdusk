<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Alert;
use App\Models\StockMovement;
use App\Models\Category;
use App\Models\Supplier;
use App\Helpers\AuthHelper;
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
        $inventoryId = AuthHelper::inventory();

        // Get key metrics for user's inventory
        $totalProducts = Product::where('inventory_id', $inventoryId)->count();
        $totalCategories = Category::where('inventory_id', $inventoryId)->count();
        $totalSuppliers = Supplier::where('inventory_id', $inventoryId)->count();

        // Low stock products (current_stock <= reorder_level)
        $lowStockProducts = Product::where('inventory_id', $inventoryId)->whereRaw('current_stock <= reorder_level')->count();
        $outOfStockProducts = Product::where('inventory_id', $inventoryId)->where('current_stock', 0)->count();

        // Alerts for this inventory
        $activeAlerts = Alert::where('status', 'unresolved')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })->count();
        $urgentAlerts = Alert::where('type', 'out_of_stock')
            ->where('status', 'unresolved')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })->count();

        // Recent stock movements for this inventory
        $recentMovements = StockMovement::with('product')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })
            ->latest()
            ->limit(10)
            ->get();

        // Low stock products details
        $lowStockList = Product::where('inventory_id', $inventoryId)
            ->whereRaw('current_stock <= reorder_level')
            ->with('category', 'supplier')
            ->orderBy('current_stock')
            ->limit(8)
            ->get();

        // Unresolved alerts
        $unresolvedAlerts = Alert::where('status', 'unresolved')
            ->with('product')
            ->whereHas('product', function ($q) use ($inventoryId) {
                $q->where('inventory_id', $inventoryId);
            })
            ->latest()
            ->limit(8)
            ->get();

        // Total inventory value (cost)
        $totalInventoryValue = Product::where('inventory_id', $inventoryId)
            ->selectRaw('SUM(current_stock * cost_price) as total')
            ->first()
            ->total ?? 0;

        // Calculate total stock quantity
        $totalStockQuantity = Product::where('inventory_id', $inventoryId)->sum('current_stock');

        // Top categories by product count in this inventory
        $topCategories = Category::with(['inventory', 'products'])
            ->where('inventory_id', $inventoryId)
            ->withCount('products')
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
