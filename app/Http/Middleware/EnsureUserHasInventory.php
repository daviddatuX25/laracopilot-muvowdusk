<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Inventory;

class EnsureUserHasInventory
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (auth()->check()) {
            // Allow logout, inventory selection, and admin routes regardless
            if ($request->routeIs(['auth.logout', 'inventory.*', 'admin.*'])) {
                return $next($request);
            }

            // Check if inventory_id is in session (user selected one)
            if (!session('inventory_id')) {
                // No inventory selected - redirect to selection page
                return redirect()->route('inventory.lobby')->with('info', 'Please select an inventory to continue.');
            }

            // Verify inventory is still active
            $inventory = Inventory::find(session('inventory_id'));
            if (!$inventory || $inventory->status === 'inactive') {
                // Inventory is inactive - clear session and redirect
                session()->forget('inventory_id');
                session()->forget('selected_inventory_name');
                return $this->logoutUser($request, 'Your assigned inventory is currently inactive. Please contact your system administrator.');
            }
        }

        return $next($request);
    }

    /**
     * Logout user and redirect with message
     */
    private function logoutUser(Request $request, $message)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // For API/AJAX requests, return error response
        if ($request->expectsJson()) {
            return response()->json(['error' => $message], 403);
        }

        // For regular requests, redirect to login with message
        return redirect('/login')->with('error', $message);
    }
}
