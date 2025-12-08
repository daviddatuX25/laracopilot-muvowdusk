<?php

namespace App\Livewire\Restock;

use Livewire\Component;
use App\Models\Restock;
use App\Services\RestockService;
use Illuminate\Support\Facades\Auth;

class RestockViewer extends Component
{
    public Restock $restock;
    public $items;
    public $summary;
    public $cartTotal;
    public $taxAmount;
    public $totalCost;
    public $budgetStatus;
    public $budgetDifference;
    protected $restockService;

    public function mount(Restock $restock)
    {
        $this->authorize('view', $restock);

        $this->restock = $restock;
        $this->restockService = app(RestockService::class);
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->items = $this->restock->items()->with('product')->get();
        $this->summary = $this->restockService->getRestockSummary($this->restock);

        // Calculate totals using the service to match builder logic
        $cartItems = $this->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'quantity' => (int) $item->quantity_requested,
                'unit_cost' => (float) $item->unit_cost,
                'subtotal' => (float) $item->subtotal,
            ];
        })->toArray();

        $costData = [
            'budget_amount' => (float) $this->restock->budget_amount,
            'tax_percentage' => (float) $this->restock->tax_percentage,
            'shipping_fee' => (float) $this->restock->shipping_fee,
            'labor_fee' => (float) $this->restock->labor_fee,
            'other_fees' => array_map(function ($fee) {
                return [
                    'amount' => (float) ($fee['amount'] ?? 0),
                    'label' => (string) ($fee['label'] ?? ''),
                ];
            }, $this->restock->other_fees ?? []),
        ];

        $calculations = $this->restockService->calculateTotalCost($cartItems, $costData);
        $this->cartTotal = $calculations['cart_total'];
        $this->taxAmount = $calculations['tax_amount'];
        $this->totalCost = $calculations['total_cost'];

        // Calculate budget status based on new totals
        $budgetStatus = $this->restockService->getBudgetStatus($this->totalCost, (float) $this->restock->budget_amount);
        $this->budgetStatus = $budgetStatus['status'];
        $this->budgetDifference = $budgetStatus['difference'];
    }

    public function render()
    {
        $header = "Re-stock Plan #" . $this->restock->id;
        view()->share('header', $header);

        return view('livewire.restock.restock-viewer', [
            'header' => $header
        ]);
    }
}
