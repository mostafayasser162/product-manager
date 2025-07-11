<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 30) as $i) {
            $product = Product::create([
                'name' => "Product $i",
                'description' => "Description for product $i",
                'image' => 'storage/images/sample.jpg',
            ]);
            
            // Attach random categories to the product
            $product->categories()->sync(Category::inRandomOrder()->limit(2)->pluck('id'));
        }
    }
}
