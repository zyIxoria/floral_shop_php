<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'min_order_value',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(): bool
    {
        $today = now()->toDateString();
        return $this->is_active &&
               $today >= $this->start_date->toDateString() &&
               $today <= $this->end_date->toDateString() &&
               ($this->usage_limit === null || $this->used_count < $this->usage_limit);
    }

    public function calculateDiscount(float $orderValue): float
    {
        if ($orderValue < $this->min_order_value) {
            return 0;
        }

        if ($this->discount_type === 'percent') {
            return round($orderValue * ($this->discount_value / 100), 2);
        }

        return min(floatval($this->discount_value), $orderValue);
    }
}
