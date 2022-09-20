<?php

namespace Tests\Feature;

use App\Domain\Product\Models\Category;
use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class APITest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_the_api_works_successfully(): void
    {
        $response = $this->get('/api/test');

        $response->assertStatus(200)
            ->assertExactJson(['message' => 'Hello World']);

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data', Product::count())
            ->has('data.0', fn($json) => $json->hasAll(['sku', 'name', 'category', 'price'])
            )
            ->has('data.0.price', fn($json) => $json->hasAll(['original', 'final', 'discount_percentage', 'currency'])
            )
        );
    }

    /**
     * @return void
     */
    public function test_the_application_can_filter_products_by_category(): void
    {
        $random_product = Product::all()->random(1)->first();
        $test_category = $random_product->category->value;

        $response = $this->get('/api/products?category=' . $test_category);

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data', Product::whereCategory($test_category)->count())
        );

        $response->assertJsonPath('data.0.category', fn($category) => $category == $test_category
        );
    }

    /**
     * @return void
     */
    public function test_the_application_can_filter_products_by_price(): void
    {
        $random_product = Product::all()->random(1)->first();
        $test_price = $random_product->price['original'];

        $response = $this->get('/api/products?price=' . $test_price);

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data', Product::wherePrice($test_price)->count())
        );

        $response->assertJsonPath('data.0.price.original', fn($price) => $price == $test_price
        );
    }

    /**
     * @return void
     */
    public function test_the_application_returns_422_with_wrong_category_supplied(): void
    {
        $response = $this->get('/api/products?category=beauty');

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_the_application_returns_422_with_wrong_price_type_supplied(): void
    {
        $response = $this->get('/api/products?price=hello');

        $response->assertStatus(422);
    }

    public function test_the_application_returns_empty_array_with_wrong_price_supplied(): void
    {
        $response = $this->get('/api/products?price=28000');

        $response->assertStatus(200);

        $response->assertJson(fn(AssertableJson $json) => $json->has('data', 0));
    }

    public function test_the_application_applies_30_percent_discount_for_insurance_products()
    {
        $test_product = Product::whereCategory(Category::Insurance)->first();

        $response = $this->get('/api/products?category=' . Category::Insurance->value);

        $response->assertStatus(200);

        $response->assertJsonPath('data.0.price.discount_percentage', fn($discount_percentage) => $discount_percentage == '30%'
        );

        $discount = $test_product->price['original'] * 0.3;
        $final_price = $test_product->price['original'] - $discount;

        $response->assertJsonPath('data.0.price.final', fn($final) => $final == $final_price
        );
    }

    public function test_the_application_applies_15_percent_discount_for_products_with_000003_sku()
    {
        $test_product = Product::whereSku('000003')->first();

        $response = $this->get('/api/products');

        $response->assertStatus(200);

        $response->assertJsonPath('data.2.price.discount_percentage', fn($discount_percentage) => $discount_percentage == '15%'
        );

        $response->assertJsonPath('data.2.sku', fn($sku) => $sku == $test_product->sku
        );

        $discount = $test_product->price['original'] * 0.15;
        $final_price = $test_product->price['original'] - $discount;

        $response->assertJsonPath('data.2.price.final', fn($final) => $final == $final_price
        );
    }

}
