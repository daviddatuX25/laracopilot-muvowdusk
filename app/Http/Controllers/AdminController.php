<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Clear admin viewing inventory flag
     */
    public function clearViewingMode()
    {
        session(['admin_viewing_inventory' => false]);
        return redirect()->route('admin.inventories');
    }
}
