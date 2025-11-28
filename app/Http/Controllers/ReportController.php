222<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function summary()
    {
        $totalProducts = Product::count();
        $totalStockValue = Product::sum(DB::raw('stock * cost_price'));
        $lowStockCount = Product::whereRaw('stock <= reorder_level')->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        return view('reports.summary', compact('totalProducts', 'totalStockValue', 'lowStockCount', 'outOfStockCount'));
    }

    public function lowStock()
    {
        $lowStockProducts = Product::whereRaw('stock <= reorder_level')->get();
        return view('reports.low-stock', compact('lowStockProducts'));
    }

    public function movementHistory(Request $request)
    {
        $query = StockMovement::with('product');

        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $stockMovements = $query->latest()->get();
        $products = Product::all();

        return view('reports.movement-history', compact('stockMovements', 'products'));
    }

    public function exportPdf(Request $request)
    {
        $reportType = $request->input('report_type');
        $data = [];

        switch ($reportType) {
            case 'summary':
                $data['totalProducts'] = Product::count();
                $data['totalStockValue'] = Product::sum(DB::raw('stock * cost_price'));
                $data['lowStockCount'] = Product::whereRaw('stock <= reorder_level')->count();
                $data['outOfStockCount'] = Product::where('stock', '<=', 0)->count();
                $view = 'reports.pdf.summary';
                break;

            case 'low-stock':
                $data['lowStockProducts'] = Product::whereRaw('stock <= reorder_level')->get();
                $view = 'reports.pdf.low-stock';
                break;

            case 'movement-history':
                $query = StockMovement::with('product');

                if ($request->has('product_id') && $request->product_id != '') {
                    $query->where('product_id', $request->product_id);
                }

                if ($request->has('type') && $request->type != '') {
                    $query->where('type', $request->type);
                }

                if ($request->has('start_date') && $request->start_date != '') {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }

                if ($request->has('end_date') && $request->end_date != '') {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }

                $data['stockMovements'] = $query->latest()->get();
                $view = 'reports.pdf.movement-history';
                break;

            default:
                return back()->with('error', 'Invalid report type');
        }

        $pdf = PDF::loadView($view, $data);
        return $pdf->download("inventory_report_{$reportType}_" . now()->format('Y-m-d') . ".pdf");
    }
}