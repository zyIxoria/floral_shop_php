<?php

namespace App\Services;

use App\Models\Coupon;

class CouponService
{
    public function validateCoupon(string $code, float $orderValue): ?Coupon
    {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return null;
        }

        if ($orderValue < $coupon->min_order_value) {
            return null;
        }

        return $coupon;
    }
}
