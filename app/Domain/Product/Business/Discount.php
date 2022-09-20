<?php

namespace App\Domain\Product\Business;

use App\Domain\Product\Models\Category;
use App\Domain\Product\Models\PriceDetail;
use App\Domain\Product\Models\Product;


class Discount
{
    private const SPECIAL_SKU = '000003';

    /**
     * @param Product $product
     * @param float $price
     */
    public function __construct(private readonly Product $product, private readonly float $price)
    {
    }

    private function getDiscountPercentage(): float
    {
        $discount_percentage = 0;

        if ($this->product->category === Category::Insurance) {
            $discount_percentage = 0.3;
        }

        if ($this->product->sku === self::SPECIAL_SKU) {
            $discount_percentage = 0.15;
        }

        return $discount_percentage;
    }

    /**
     * @return array
     */
    public function getPriceDetails(): array
    {
        $discount = $this->price * $this->getDiscountPercentage();
        $finalPrice = $this->price - $discount;

        return (new PriceDetail(
            $this->price,
            $this->getDiscountPercentage(),
            $finalPrice,
        ))->toArray();
    }
}
