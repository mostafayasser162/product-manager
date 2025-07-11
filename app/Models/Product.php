<?php

namespace App\Models;

use App\Models\Scopes\SortScope;
use App\Models\Scopes\SearchScope;
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

        protected static function booted(): void
    {
        static::addGlobalScope(new SortScope);
        static::addGlobalScope(new SearchScope);
    }
}
