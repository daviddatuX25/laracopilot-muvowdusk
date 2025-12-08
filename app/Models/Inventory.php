<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'status',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserInventory::class);
    }

    public function restocks(): HasMany
    {
        return $this->hasMany(Restock::class);
    }

    public function restockCosts(): HasMany
    {
        return $this->hasMany(RestockCost::class);
    }
}
