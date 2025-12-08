<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Category\CategoryList;
use App\Livewire\Category\CategoryCreate;
use App\Livewire\Category\CategoryEdit;
use App\Livewire\Product\ProductList;
use App\Livewire\Product\ProductCreate;
use App\Livewire\Product\ProductEdit;
use App\Livewire\Supplier\SupplierList;
use App\Livewire\Supplier\SupplierCreate;
use App\Livewire\Supplier\SupplierEdit;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestockController;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\InventoryManagement;
use App\Livewire\Admin\UserInventoryLink;
use App\Http\Controllers\AdminController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// Inventory Lobby Route
Route::middleware('auth')->group(function () {
    Route::get('/lobby', [\App\Http\Controllers\InventorySelectionController::class, 'show'])->name('inventory.lobby');
    Route::post('/lobby', [\App\Http\Controllers\InventorySelectionController::class, 'store'])->name('inventory.lobby.store');
});

// Dashboard & Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\Dashboard::class)->name('dashboard');

    Route::get('/categories', CategoryList::class)->name('categories.index');
    Route::get('/categories/create', CategoryCreate::class)->name('categories.create');
    Route::get('/categories/{category}/edit', CategoryEdit::class)->name('categories.edit');

    Route::get('/products', ProductList::class)->name('products.index');
    Route::get('/products/create', ProductCreate::class)->name('products.create');
    Route::get('/products/{product}/edit', ProductEdit::class)->name('products.edit');

    Route::get('/suppliers', SupplierList::class)->name('suppliers.index');
    Route::get('/suppliers/create', SupplierCreate::class)->name('suppliers.create');
    Route::get('/suppliers/{supplier}/edit', SupplierEdit::class)->name('suppliers.edit');

    Route::get('/barcode-scan', \App\Livewire\BarcodeScanner::class)->name('barcode.scan');

    Route::get('/stock-movements/adjust', \App\Livewire\Stock\StockAdjustment::class)->name('stock-movements.adjust');

    Route::get('/reports', \App\Livewire\Report\ReportDashboard::class)->name('reports.index');
    Route::get('/reports/low-stock', \App\Livewire\Report\LowStockReport::class)->name('reports.low-stock');
    Route::get('/reports/movement-history', \App\Livewire\Report\MovementHistoryReport::class)->name('reports.movement-history');
    Route::get('/reports/full-inventory', \App\Livewire\Report\FullInventoryReport::class)->name('reports.full-inventory');

    // Restock Routes
    Route::get('/restock', \App\Livewire\Restock\RestockBuilder::class)->name('restock.builder');
    Route::get('/restock/plans/{restock}/edit', \App\Livewire\Restock\RestockBuilder::class)->name('restock.edit');
    Route::post('/restock', [RestockController::class, 'store'])->name('restock.store');
    Route::get('/restock/plans', [RestockController::class, 'plans'])->name('restock.plans');
    Route::get('/restock/plans/{restock}', [RestockController::class, 'show'])->name('restock.show');
    Route::put('/restock/plans/{restock}', [RestockController::class, 'update'])->name('restock.update');
    Route::get('/restock/plans/{restock}/fulfill', [RestockController::class, 'fulfill'])->name('restock.fulfill');
    Route::post('/restock/plans/{restock}/fulfill', [RestockController::class, 'confirmFulfill'])->name('restock.confirmFulfill');
    Route::delete('/restock/plans/{restock}', [RestockController::class, 'destroy'])->name('restock.destroy');
    Route::get('/restock/plans/{restock}/print', [RestockController::class, 'printPlan'])->name('restock.print-plan');
    Route::get('/restock/plans/{restock}/receipt', [RestockController::class, 'printReceipt'])->name('restock.print-receipt');

    Route::get('/alerts', \App\Livewire\AlertsList::class)->name('alerts.index');

    // Admin Routes - Admin Only
    Route::middleware('admin')->group(function () {
        Route::get('/admin', function () {
            return redirect()->route('admin.users');
        })->name('admin.dashboard');
        Route::get('/admin/clear-viewing-mode', [AdminController::class, 'clearViewingMode'])->name('admin.clear-viewing-mode');
        Route::get('/admin/users', UserManagement::class)->name('admin.users');
        Route::get('/admin/inventories', InventoryManagement::class)->name('admin.inventories');
        Route::get('/admin/user-inventory-links', UserInventoryLink::class)->name('admin.user-inventory-links');
        Route::get('/admin/inventory/{inventory}/view', [\App\Http\Controllers\AdminInventoryViewController::class, 'show'])->name('admin.view-inventory');
    });

    // API Routes for AJAX
    Route::get('/api/products/search', function (\Illuminate\Http\Request $request) {
        $q = $request->query('q');
        $product = \App\Models\Product::where('barcode', $q)->orWhere('sku', $q)->first();

        if ($product) {
            return response()->json([
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'current_stock' => $product->current_stock,
                    'image_path' => $product->image_path,
                    'category' => $product->category,
                    'supplier' => $product->supplier,
                ]
            ]);
        }

        return response()->json(['product' => null], 404);
    });
});
