<?php

namespace App\Domain\Product\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
