<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Business\Discount;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Product
 *
 * @property string $sku
 * @property string $name
 * @property Category $category
 * @property float $price
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereCategory($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public static array $filters = [
        'price',
        'category'
    ];

    protected $casts = [
        'sku' => 'string',
        'name' => 'string',
        'category' => Category::class,
        'price' => 'float',
    ];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => (new Discount($this, $value))->getPriceDetails()
        );
    }
}
