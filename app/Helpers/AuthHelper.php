<?php

namespace App\Helpers;

use App\Models\Inventory;

class AuthHelper
{
    /**
     * Get the current user's selected inventory ID.
     * This is stored in the session after user selection.
     */
    public static function inventory()
    {
        return session('inventory_id');
    }

    /**
     * Get the current user's selected inventory name.
     */
    public static function inventoryName()
    {
        return session('selected_inventory_name', 'Unknown Inventory');
    }

    /**
     * Get the full inventory object.
     */
    public static function inventoryObject()
    {
        $inventoryId = session('inventory_id');
        if ($inventoryId) {
            return Inventory::find($inventoryId);
        }
        return null;
    }

    /**
     * Check if user has an assigned inventory.
     */
    public static function hasInventory()
    {
        return !is_null(session('inventory_id'));
    }

    /**
     * Switch to different inventory (for users with multiple inventories)
     */
    public static function switchInventory($inventoryId)
    {
        $user = auth()->user();
        $inventory = $user->inventories()
            ->where('inventories.id', $inventoryId)
            ->where('status', 'active')
            ->first();

        if ($inventory) {
            session(['inventory_id' => $inventoryId]);
            session(['selected_inventory_name' => $inventory->name]);
            return true;
        }
        return false;
    }
}
