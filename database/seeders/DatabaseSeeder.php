<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PriceSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PriceSeeder::class,
        ]);
    }
}
