<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Restock;
use App\Services\RestockService;
use App\Services\RestockCostManager;
use App\Services\RestockPrintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestockController extends Controller
{
    protected RestockService $restockService;
    protected RestockCostManager $costManager;
    protected RestockPrintService $printService;

    public function __construct(
        RestockService $restockService,
        RestockCostManager $costManager,
        RestockPrintService $printService
    ) {
        $this->restockService = $restockService;
        $this->costManager = $costManager;
        $this->printService = $printService;
        $this->middleware('auth');
    }

    /**
     * Store a new restock plan
     */
    public function store(Request $request)
    {
        $inventoryId = session('inventory_id');
        if (!$inventoryId) {
            return response()->json([
                'success' => false,
                'message' => 'No inventory selected',
            ], 422);
        }

        $inventory = Inventory::findOrFail($inventoryId);
        if (!Auth::user()->inventories->contains($inventory)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'budget_amount' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'shipping_fee' => 'nullable|numeric|min:0',
            'labor_fee' => 'nullable|numeric|min:0',
            'other_fees' => 'nullable|array',
            'other_fees.*.label' => 'required|string|max:50',
            'other_fees.*.amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        try {
            $restock = $this->restockService->createRestockPlan(
                $inventory,
                Auth::user(),
                $validated['items'],
                [
                    'budget_amount' => $validated['budget_amount'],
                    'tax_percentage' => $validated['tax_percentage'] ?? 0,
                    'shipping_fee' => $validated['shipping_fee'] ?? 0,
                    'labor_fee' => $validated['labor_fee'] ?? 0,
                    'other_fees' => $validated['other_fees'] ?? [],
                ],
                $validated['notes'] ?? null
            );

            return response()->json([
                'success' => true,
                'message' => 'Restock plan created successfully',
                'restock_id' => $restock->id,
                'redirect' => route('restock.show', $restock),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create restock plan: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update an existing restock plan
     */
    public function update(Request $request, Restock $restock)
    {
        $this->authorize('update', $restock);

        $validated = $request->validate([
            'budget_amount' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'shipping_fee' => 'nullable|numeric|min:0',
            'labor_fee' => 'nullable|numeric|min:0',
            'other_fees' => 'nullable|array',
            'other_fees.*.label' => 'required|string|max:50',
            'other_fees.*.amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        try {
            $restock = $this->restockService->updateRestockPlan(
                $restock,
                $validated['items'],
                [
                    'budget_amount' => $validated['budget_amount'],
                    'tax_percentage' => $validated['tax_percentage'] ?? 0,
                    'shipping_fee' => $validated['shipping_fee'] ?? 0,
                    'labor_fee' => $validated['labor_fee'] ?? 0,
                    'other_fees' => $validated['other_fees'] ?? [],
                ],
                $validated['notes'] ?? null
            );

            return response()->json([
                'success' => true,
                'message' => 'Restock plan updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update restock plan: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Show list of saved restock plans
     */
    public function plans(Request $request)
    {
        $inventoryId = session('inventory_id');
        if (!$inventoryId) {
            return redirect()->route('inventory.lobby');
        }

        $inventory = Inventory::findOrFail($inventoryId);
        if (!Auth::user()->inventories->contains($inventory)) {
            return redirect()->route('inventory.lobby');
        }

        // Only get restock plans created by the current user in this inventory
        $query = $inventory->restocks()->where('user_id', Auth::id());

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy('created_at', $sortOrder);

        $restocks = $query->paginate(15);

        return view('restock.plans-list', [
            'restocks' => $restocks,
            'inventory' => $inventory,
        ]);
    }

    /**
     * Show details of a single restock plan
     */
    public function show(Request $request, Restock $restock)
    {
        $this->authorize('view', $restock);

        return view('restock.details', [
            'restock' => $restock,
        ]);
    }

    /**
     * Show fulfillment confirmation page
     */
    public function fulfill(Request $request, Restock $restock)
    {
        $this->authorize('fulfill', $restock);

        if ($restock->isFulfilled()) {
            return redirect()->route('restock.show', $restock)
                ->with('error', 'This restock plan has already been fulfilled.');
        }

        $items = $restock->items()->with('product')->get();
        $summary = $this->restockService->getRestockSummary($restock);

        return view('restock.fulfill', [
            'restock' => $restock,
            'items' => $items,
            'summary' => $summary,
        ]);
    }

    /**
     * Confirm fulfillment and update stock
     */
    public function confirmFulfill(Request $request, Restock $restock)
    {
        $this->authorize('fulfill', $restock);

        try {
            $restock = $this->restockService->fulfillRestockPlan($restock, Auth::user());

            return redirect()->route('restock.show', $restock)
                ->with('success', 'Restock plan fulfilled successfully! Stock has been updated.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to fulfill restock plan: ' . $e->getMessage());
        }
    }

    /**
     * Delete a restock plan
     */
    public function destroy(Request $request, Restock $restock)
    {
        $this->authorize('delete', $restock);

        if ($restock->isFulfilled()) {
            return redirect()->back()
                ->with('error', 'Cannot delete a fulfilled restock plan.');
        }

        $restock->delete();

        return redirect()->route('restock.plans')
            ->with('success', 'Restock plan deleted successfully.');
    }

    /**
     * Print restock plan sheet
     */
    public function printPlan(Request $request, Restock $restock)
    {
        $this->authorize('view', $restock);

        return $this->printService->exportPlanToPDF($restock);
    }

    /**
     * Print restock receipt
     */
    public function printReceipt(Request $request, Restock $restock)
    {
        $this->authorize('view', $restock);

        return $this->printService->exportReceiptToPDF($restock);
    }
}
