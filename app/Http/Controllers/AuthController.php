<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'userid' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('userid', $credentials['userid'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['auth' => 'Invalid userid or password.'])->onlyInput('userid');
        }

        Auth::login($user);

        // Admins go to admin panel
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // All users go to inventory lobby page (even if single inventory)
        // This provides a central hub where users can:
        // - See all their assigned inventories (active/inactive)
        // - Contact admin if needed
        // - Select which inventory to work with

        $inventories = $user->inventories()->get();

        // If no inventories assigned - logout
        if ($inventories->isEmpty()) {
            Auth::logout();
            return back()->withErrors(['auth' => 'You have no inventories assigned.'])->onlyInput('userid');
        }

        // Redirect to inventory lobby page
        return redirect()->route('inventory.lobby');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

