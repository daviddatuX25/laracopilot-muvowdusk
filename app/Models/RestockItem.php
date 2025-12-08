<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestockItem extends Model
{
    protected $fillable = [
        'restock_id',
        'product_id',
        'quantity_requested',
        'unit_cost',
        'subtotal',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the restock plan this item belongs to
     */
    public function restock(): BelongsTo
    {
        return $this->belongsTo(Restock::class);
    }

    /**
     * Get the product for this restock item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
