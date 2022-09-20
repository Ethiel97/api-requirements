<?php

namespace App\Domain\Product\Commands;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Resources\ProductResource;
use App\Infrastructure\Http\Requests\ProductRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetProducts
{
    public function __invoke(ProductRequest $productRequest): AnonymousResourceCollection
    {
        $products = Product::where($productRequest->filter()->toArray())->get();

        return ProductResource::collection($products);
    }
}
