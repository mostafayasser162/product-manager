<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceService
{

    public function baseQueryWithCurrentPrice(): Builder
    {
        $today = Carbon::today()->toDateString();

        return Product::query()
            ->leftJoin('prices', function ($join) use ($today) {
                $join->on('products.id', '=', 'prices.product_id')
                    ->whereDate('prices.start_date', '<=', $today)
                    ->whereDate('prices.end_date', '>=', $today);
            })
            ->select(
                'products.*',
                DB::raw('prices.price AS current_price')
            );
    }
}
