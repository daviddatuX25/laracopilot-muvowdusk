<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Restock;
use App\Models\RestockItem;
use App\Models\RestockCost;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RestockService
{
    /**
     * Calculate total cost based on cart items, taxes, and fees
     */
    public function calculateTotalCost(array $cartItems, array $costs): array
    {
        $cartTotal = 0;

        // Calculate cart total
        foreach ($cartItems as $item) {
            $subtotal = $item['quantity'] * $item['unit_cost'];
            $cartTotal += $subtotal;
        }

        // Calculate tax
        $taxPercentage = $costs['tax_percentage'] ?? 0;
        $taxAmount = ($cartTotal * $taxPercentage) / 100;

        // Calculate total fees
        $shippingFee = $costs['shipping_fee'] ?? 0;
        $laborFee = $costs['labor_fee'] ?? 0;
        $otherFees = $costs['other_fees'] ?? [];

        $otherFeesTotal = 0;
        foreach ($otherFees as $fee) {
            if (isset($fee['amount'])) {
                // $otherFeesTotal += $fee['amount'];
                // convert to float to avoid string concatenation issues
                $otherFeesTotal += (float) $fee['amount'] ?? 0;
            }
        }

        // Calculate total cost
        $totalCost = $cartTotal + $taxAmount + $shippingFee + $laborFee + $otherFeesTotal;

        return [
            'cart_total' => round($cartTotal, 2),
            'tax_amount' => round($taxAmount, 2),
            'total_cost' => round($totalCost, 2),
        ];
    }

    /**
     * Determine budget status (under/fit/over)
     */
    public function getBudgetStatus(float $totalCost, float $budget): array
    {
        $difference = $budget - $totalCost;

        // If difference is negative, you're over budget
        // If difference is positive, you're under budget
        if ($difference < 0) {
            $status = 'under';
        } else if ($difference == 0) {
            $status = 'fit';
        } else {
            $status = 'over';
        }

        return [
            'status' => $status,
            'difference' => abs(round($difference, 2)),
        ];
    }

    /**
     * Create a new restock plan from cart data
     */
    public function createRestockPlan(
        Inventory $inventory,
        User $user,
        array $cartItems,
        array $costData,
        string $notes = null
    ): Restock {
        return DB::transaction(function () use ($inventory, $user, $cartItems, $costData, $notes) {
            // Calculate totals
            $calculations = $this->calculateTotalCost($cartItems, $costData);
            $budgetStatus = $this->getBudgetStatus($calculations['total_cost'], $costData['budget_amount']);

            // Create restock plan
            $restock = $inventory->restocks()->create([
                'user_id' => $user->id,
                'status' => 'pending',
                'budget_amount' => $costData['budget_amount'],
                'cart_total' => $calculations['cart_total'],
                'tax_percentage' => $costData['tax_percentage'] ?? 0,
                'tax_amount' => $calculations['tax_amount'],
                'shipping_fee' => $costData['shipping_fee'] ?? 0,
                'labor_fee' => $costData['labor_fee'] ?? 0,
                'other_fees' => $costData['other_fees'] ?? [],
                'total_cost' => $calculations['total_cost'],
                'budget_status' => $budgetStatus['status'],
                'budget_difference' => $budgetStatus['difference'],
                'notes' => $notes,
            ]);

            // Create restock items
            foreach ($cartItems as $item) {
                $subtotal = round($item['quantity'] * $item['unit_cost'], 2);

                RestockItem::create([
                    'restock_id' => $restock->id,
                    'product_id' => $item['product_id'],
                    'quantity_requested' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);
            }

            return $restock;
        });
    }

    /**
     * Update an existing restock plan
     */
    public function updateRestockPlan(
        Restock $restock,
        array $cartItems,
        array $costData,
        string $notes = null
    ): Restock {
        return DB::transaction(function () use ($restock, $cartItems, $costData, $notes) {
            // Calculate totals
            $calculations = $this->calculateTotalCost($cartItems, $costData);
            $budgetStatus = $this->getBudgetStatus($calculations['total_cost'], $costData['budget_amount']);

            // Update restock plan
            $restock->update([
                'budget_amount' => $costData['budget_amount'],
                'cart_total' => $calculations['cart_total'],
                'tax_percentage' => $costData['tax_percentage'] ?? 0,
                'tax_amount' => $calculations['tax_amount'],
                'shipping_fee' => $costData['shipping_fee'] ?? 0,
                'labor_fee' => $costData['labor_fee'] ?? 0,
                'other_fees' => $costData['other_fees'] ?? [],
                'total_cost' => $calculations['total_cost'],
                'budget_status' => $budgetStatus['status'],
                'budget_difference' => $budgetStatus['difference'],
                'notes' => $notes,
            ]);

            // Delete existing items and recreate them
            $restock->items()->delete();

            foreach ($cartItems as $item) {
                $subtotal = round($item['quantity'] * $item['unit_cost'], 2);

                RestockItem::create([
                    'restock_id' => $restock->id,
                    'product_id' => $item['product_id'],
                    'quantity_requested' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'subtotal' => $subtotal,
                ]);
            }

            return $restock->fresh();
        });
    }

    /**
     * Fulfill a restock plan: update stock for all products
     */
    public function fulfillRestockPlan(Restock $restock, User $user): Restock
    {
        return DB::transaction(function () use ($restock, $user) {
            if ($restock->isFulfilled()) {
                throw new \Exception('This restock plan has already been fulfilled.');
            }

            // Update stock for each item and create stock movements
            foreach ($restock->items as $item) {
                $product = $item->product;
                $oldStock = $product->current_stock;
                $newStock = $oldStock + $item->quantity_requested;

                // Update product stock
                $product->update([
                    'current_stock' => $newStock,
                ]);

                // Create stock movement record
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item->quantity_requested,
                    'old_stock' => $oldStock,
                    'new_stock' => $newStock,
                    'reason' => 'restock_fulfillment',
                    'restock_id' => $restock->id,
                ]);
            }

            // Update restock status
            $restock->update([
                'status' => 'fulfilled',
                'fulfilled_at' => now(),
                'fulfilled_by' => $user->id,
            ]);

            return $restock->fresh();
        });
    }

    /**
     * Cancel a restock plan
     */
    public function cancelRestockPlan(Restock $restock, string $reason = null): Restock
    {
        $restock->update([
            'status' => 'cancelled',
            'notes' => $restock->notes . "\n\n--- Cancelled ---\n" . $reason,
        ]);

        return $restock->fresh();
    }

    /**
     * Get restock plan summary for display
     */
    public function getRestockSummary(Restock $restock): array
    {
        return [
            'id' => $restock->id,
            'inventory_id' => $restock->inventory_id,
            'status' => $restock->status,
            'items_count' => $restock->items()->count(),
            'cart_total' => '₱' . number_format((float) $restock->cart_total, 2),
            'tax' => '₱' . number_format((float) $restock->tax_amount, 2),
            'tax_amount' => (float) $restock->tax_amount,
            'shipping' => '₱' . number_format((float) $restock->shipping_fee, 2),
            'shipping_fee' => (float) $restock->shipping_fee,
            'labor' => '₱' . number_format((float) $restock->labor_fee, 2),
            'labor_fee' => (float) $restock->labor_fee,
            'total_cost' => '₱' . number_format((float) $restock->total_cost, 2),
            'budget' => '₱' . number_format((float) $restock->budget_amount, 2),
            'budget_amount' => (float) $restock->budget_amount,
            'budget_status' => $restock->budget_status,
            'budget_difference' => (float) $restock->budget_difference,
            'difference' => number_format(abs((float) $restock->budget_difference), 2),
            'notes' => $restock->notes,
            'created_at' => $restock->created_at,
            'fulfilled_at' => $restock->fulfilled_at,
            'fulfilled_by' => $restock->fulfilledBy?->name,
        ];
    }
}
