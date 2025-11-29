<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class AdminInventoryViewController extends Controller
{
    /**
     * Show inventory data for admin to view/work with
     */
    public function show(Inventory $inventory)
    {
        // Admin viewing an inventory - set it in session
        session(['inventory_id' => $inventory->id]);
        session(['selected_inventory_name' => $inventory->name]);
        session(['admin_viewing_inventory' => true]);

        return redirect()->route('dashboard');
    }
}
