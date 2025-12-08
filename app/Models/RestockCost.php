<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestockCost extends Model
{
    protected $fillable = [
        'inventory_id',
        'user_id',
        'cost_type',
        'label',
        'amount',
        'is_percentage',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_percentage' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inventory this cost template belongs to
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Get the user who created this cost template
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to only active costs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by cost type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('cost_type', $type);
    }
}
