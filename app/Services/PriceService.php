<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class PriceService
{
    /**
     * @param  int         $productId
     * @param  string      $startDate
     * @param  int|null    $ignoreId
     */
    public function hasConflict(int $productId, string $startDate, ?int $ignoreId = null): bool
    {
        return DB::table('prices')
            ->where('product_id', $productId)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->whereDate('start_date', '<=', $startDate)
            ->whereDate('end_date',   '>=', $startDate)
            ->exists();
    }
}
