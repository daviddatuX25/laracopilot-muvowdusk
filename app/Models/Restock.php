<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restock extends Model
{
    protected $fillable = [
        'inventory_id',
        'user_id',
        'status',
        'budget_amount',
        'cart_total',
        'tax_percentage',
        'tax_amount',
        'shipping_fee',
        'labor_fee',
        'other_fees',
        'total_cost',
        'budget_status',
        'budget_difference',
        'notes',
        'fulfilled_at',
        'fulfilled_by',
    ];

    protected $casts = [
        'other_fees' => 'array',
        'budget_amount' => 'decimal:2',
        'cart_total' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'labor_fee' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'budget_difference' => 'decimal:2',
        'fulfilled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inventory this restock plan belongs to
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the user who created this restock plan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who fulfilled this restock plan
     */
    public function fulfilledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fulfilled_by');
    }

    /**
     * Get all items in this restock plan
     */
    public function items(): HasMany
    {
        return $this->hasMany(RestockItem::class);
    }

    /**
     * Get all stock movements created from fulfilling this plan
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Check if this plan is draft status
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Check if this plan is pending status
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if this plan is fulfilled status
     */
    public function isFulfilled(): bool
    {
        return $this->status === 'fulfilled';
    }

    /**
     * Check if this plan is cancelled status
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if plan is under budget
     */
    public function isUnderBudget(): bool
    {
        return $this->budget_status === 'under';
    }

    /**
     * Check if plan is over budget
     */
    public function isOverBudget(): bool
    {
        return $this->budget_status === 'over';
    }
}
