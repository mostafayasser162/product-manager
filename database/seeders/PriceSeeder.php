<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Price;
use Carbon\Carbon;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Product::all() as $product) {
            Price::create([
                'product_id' => $product->id,
                'price' => rand(100, 1000),
                'start_date' => Carbon::now()->subDays(rand(5, 15))->toDateString(),
                'end_date' => Carbon::now()->addDays(rand(5, 15))->toDateString(),
            ]);
        }
    }
}
