<?php

namespace App\Domain\Product\Controllers;

use App\Domain\Product\Commands\GetProducts;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\ProductRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductGetController extends Controller
{
    //

    public function __invoke(ProductRequest $request): AnonymousResourceCollection
    {
        $getProducts = new GetProducts();

        return $getProducts($request);
    }


}
