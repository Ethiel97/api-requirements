<?php

namespace App\Domain\Product\Models;

use JetBrains\PhpStorm\ArrayShape;

class PriceDetail
{
    /**
     * @param float $original
     * @param float $discountPercentage
     * @param float $finalPrice
     * @param Currency $currency
     */
    public function __construct(private readonly float    $original,
                                private readonly float    $discountPercentage,
                                private readonly float    $finalPrice,
                                private readonly Currency $currency = Currency::Euro)
    {

    }

    /**
     * @return array[]
     */
    #[ArrayShape(['original' => "float", 'final' => "float", 'discount_percentage' => "null|string", 'currency' => "\App\Domain\Product\Models\Currency"])] public function toArray(): array
    {
        return [
            'original' => $this->original,
            'final' => $this->finalPrice,
            'discount_percentage' => $this->discountPercentage == 0 ? null : $this->discountPercentage * 100 . '%',
            'currency' => $this->currency,
        ];
    }
}
