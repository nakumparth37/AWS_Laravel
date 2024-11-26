<?php

namespace App\Helpers;

class PriceHelper
{
    /**
     * Calculate the price after applying a discount percentage.
     *
     * @param float $price          Original price of the product
     * @param float $discountPercent Discount percentage to apply
     * @return float                Final price after discount
     */
    public static function calculateFinalPrice(float $price, float $discountPercent): float
    {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Discount percentage must be between 0 and 100.');
        }

        $discountAmount = ($price * $discountPercent) / 100;
        return round($price - $discountAmount, 2); // Round to 2 decimal places
    }
}
