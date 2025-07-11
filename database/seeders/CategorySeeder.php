<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Furniture'],
            ['name' => 'Electronics'],
            ['name' => 'Clothing'],
            ['name' => 'Books'],
            ['name' => 'Toys'],
            ['name' => 'Sports'],
            ['name' => 'Home Decor'],
            ['name' => 'Garden'],
            ['name' => 'Stationery'],
            ['name' => 'Kitchen'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
