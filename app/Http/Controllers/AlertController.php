<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::with('product')->where('is_resolved', false)->latest()->get();
        return view('alerts.index', compact('alerts'));
    }

    public function resolve(Alert $alert)
    {
        DB::beginTransaction();
        try {
            $alert->update(['is_resolved' => true]);
            DB::commit();
            return redirect()->route('alerts.index')->with('success', 'Alert resolved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to resolve alert: ' . $e->getMessage());
        }
    }
}