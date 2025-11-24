<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    public function index()
    {
        $stockMovements = StockMovement::with('product')->latest()->get();
        return view('stock-movements.index', compact('stockMovements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('stock-movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer',
            'reason' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($validated['product_id']);
            $previousStock = $product->stock;

            if ($validated['type'] === 'out' && ($previousStock - $validated['quantity']) < 0) {
                return back()->with('error', 'Cannot reduce stock below zero. Please adjust stock or provide a reason.');
            }

            if ($validated['type'] === 'adjustment' && ($previousStock + $validated['quantity']) < 0) {
                if (empty($validated['reason'])) {
                    return back()->with('error', 'Reason is required for negative stock adjustments.');
                }
            }

            $newStock = $previousStock;
            if ($validated['type'] === 'in') {
                $newStock += $validated['quantity'];
            } elseif ($validated['type'] === 'out') {
                $newStock -= $validated['quantity'];
            } elseif ($validated['type'] === 'adjustment') {
                $newStock += $validated['quantity'];
            }

            $stockMovement = StockMovement::create([
                'product_id' => $validated['product_id'],
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'reason' => $validated['reason'],
            ]);

            $product->stock = $newStock;
            $product->save();

            // Check for low stock alert
            if ($newStock <= $product->reorder_level) {
                Alert::create([
                    'product_id' => $product->id,
                    'type' => 'low_stock',
                    'message' => "Product {$product->name} is below reorder level ({$newStock} <= {$product->reorder_level})",
                    'is_resolved' => false,
                ]);
            }

            // Check for out of stock alert
            if ($newStock <= 0) {
                Alert::create([
                    'product_id' => $product->id,
                    'type' => 'out_of_stock',
                    'message' => "Product {$product->name} is out of stock",
                    'is_resolved' => false,
                ]);
            }

            DB::commit();
            return redirect()->route('stock-movements.index')->with('success', 'Stock movement recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record stock movement: ' . $e->getMessage());
        }
    }
}