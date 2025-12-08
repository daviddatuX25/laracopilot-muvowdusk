<?php

namespace App\Services;

use App\Models\Restock;
use Barryvdh\DomPDF\Facade\Pdf;

class RestockPrintService
{
    /**
     * Generate printable plan sheet (pre-purchase guidance)
     */
    public function generatePlanSheet(Restock $restock): string
    {
        $data = [
            'restock' => $restock,
            'items' => $restock->items()->with('product')->get(),
            'inventory' => $restock->inventory,
            'type' => 'plan',
        ];

        return view('restock.print.plan-sheet', $data)->render();
    }

    /**
     * Generate printable receipt (post-fulfillment)
     */
    public function generateReceipt(Restock $restock): string
    {
        $data = [
            'restock' => $restock,
            'items' => $restock->items()->with('product')->get(),
            'inventory' => $restock->inventory,
            'type' => 'receipt',
        ];

        return view('restock.print.receipt', $data)->render();
    }

    /**
     * Export plan sheet to PDF
     */
    public function exportPlanToPDF(Restock $restock)
    {
        $html = $this->generatePlanSheet($restock);

        $pdf = Pdf::loadHTML($html);

        return $pdf->download("restock-plan-{$restock->id}.pdf");
    }

    /**
     * Export receipt to PDF
     */
    public function exportReceiptToPDF(Restock $restock)
    {
        $html = $this->generateReceipt($restock);

        $pdf = Pdf::loadHTML($html);

        return $pdf->download("restock-receipt-{$restock->id}.pdf");
    }

    /**
     * Get formatted summary for printing
     */
    public function getFormattedSummary(Restock $restock): array
    {
        return [
            'plan_id' => $restock->id,
            'created_date' => $restock->created_at->format('Y-m-d H:i'),
            'items_count' => $restock->items()->count(),
            'cart_total' => number_format((float)$restock->cart_total, 2),
            'tax' => number_format((float)$restock->tax_amount, 2),
            'shipping' => number_format((float)$restock->shipping_fee, 2),
            'labor' => number_format((float)$restock->labor_fee, 2),
            'total_cost' => number_format((float)$restock->total_cost, 2),
            'budget' => number_format((float)$restock->budget_amount, 2),
            'budget_status' => strtoupper($restock->budget_status),
            'difference' => number_format(abs((float)$restock->budget_difference), 2),
        ];
    }
}
