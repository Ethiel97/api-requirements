<?php

namespace App\Domain\Product\Models;

class FilterParams
{

    public string $category;
    public string $price;

    public function toArray(): array
    {
        return (array)$this;
    }
}
