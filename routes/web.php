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


// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

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

Route::get('/reports/summary', \App\Livewire\Report\SummaryReport::class)->name('reports.summary');
Route::get('/reports/low-stock', \App\Livewire\Report\LowStockReport::class)->name('reports.low-stock');
Route::get('/reports/movement-history', \App\Livewire\Report\MovementHistoryReport::class)->name('reports.movement-history');
Route::get('/reports/full-inventory', \App\Livewire\Report\FullInventoryReport::class)->name('reports.full-inventory');

Route::get('/alerts', \App\Livewire\AlertsList::class)->name('alerts.index');

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
