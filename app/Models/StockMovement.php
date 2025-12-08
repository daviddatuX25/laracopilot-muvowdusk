<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'inventory_id',
        'type',
        'quantity',
        'old_stock',
        'new_stock',
        'reason',
        'reference_id',
        'restock_id',
        'notes',
        'created_by',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
