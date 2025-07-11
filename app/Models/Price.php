<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory , Traits\DynamicPerPage;

    protected $fillable = ['product_id', 'price', 'start_date', 'end_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
