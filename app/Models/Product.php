<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory , Traits\DynamicPerPage;

    protected $fillable = ['name', 'image', 'description' , 'category_ids'];

    protected $casts = [
        'category_ids' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
