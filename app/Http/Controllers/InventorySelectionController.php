<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventorySelectionController extends Controller
{
    /**
     * Show inventory lobby page
     * Users see all their assigned inventories (active and inactive)
     * Inactive inventories are displayed but disabled
     */
    public function show()
    {
        $user = auth()->user();

        // Admins should not access inventory selection - they use admin panel
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // Get all assigned inventories (both active and inactive)
        $inventories = $user->inventories()->get();
        $currentInventoryId = session('inventory_id');

        return view('inventory-lobby', [
            'inventories' => $inventories,
            'currentInventoryId' => $currentInventoryId,
        ]);
    }

    /**
     * Store selected inventory
     * Validates that inventory is active before allowing access
     */
    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
        ]);

        $user = auth()->user();

        // Verify user has access to this inventory
        $inventory = $user->inventories()
            ->where('inventories.id', $request->inventory_id)
            ->first();

        if (!$inventory) {
            return back()->with('error', 'Invalid inventory selected.');
        }

        // Check if inventory is active - block access if inactive
        if ($inventory->status !== 'active') {
            return back()->with('error', 'This inventory is currently inactive and cannot be accessed. Please contact your administrator.');
        }

        // Store inventory in session
        session(['inventory_id' => $inventory->id]);
        session(['selected_inventory_name' => $inventory->name]);
        session(['admin_viewing_inventory' => false]); // Clear admin viewing flag for regular users

        return redirect()->route('dashboard');
    }
}

