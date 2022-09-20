<?php

namespace Database\Seeders;

use App\domain\Product\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        Product::insert($this->getData());
    }

    protected function getData()
    {
        $path = database_path() . '/seeders/data.json';

        return json_decode(file_get_contents($path), true)['products'];
    }
}
