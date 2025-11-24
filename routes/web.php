<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AlertController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);

Route::get('/stock-movements', [StockMovementController::class, 'index'])->name('stock-movements.index');
Route::post('/stock-movements', [StockMovementController::class, 'store'])->name('stock-movements.store');
Route::get('/stock-movements/create', [StockMovementController::class, 'create'])->name('stock-movements.create');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/summary', [ReportController::class, 'summary'])->name('reports.summary');
Route::get('/reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
Route::get('/reports/movement-history', [ReportController::class, 'movementHistory'])->name('reports.movement-history');
Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');

Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
Route::post('/alerts/{alert}/resolve', [AlertController::class, 'resolve'])->name('alerts.resolve');