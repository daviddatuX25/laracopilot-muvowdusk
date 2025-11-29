<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type',
        'message',
        'status',
        'resolved_at',
        'seen_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'resolved_at' => 'datetime',
        'seen_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isUrgent()
    {
        return $this->type === 'out_of_stock';
    }

    public function isSeen()
    {
        return $this->seen_at !== null;
    }

    public function markAsSeen()
    {
        if (!$this->isSeen()) {
            $this->update(['seen_at' => now()]);
        }
        return $this;
    }

    public function getFormattedAge()
    {
        $seconds = (int) abs(now()->diffInSeconds($this->created_at));

        if ($seconds < 60) {
            return $seconds . 's ago';
        }

        $minutes = (int) abs(now()->diffInMinutes($this->created_at));
        if ($minutes < 60) {
            return $minutes . 'm ago';
        }

        $hours = (int) abs(now()->diffInHours($this->created_at));
        if ($hours < 24) {
            return $hours . 'h ago';
        }

        $days = (int) abs(now()->diffInDays($this->created_at));
        return $days . 'd ago';
    }
}
