<?php

namespace App\Models;

use App\Models\Scopes\SortScope;
use App\Models\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Traits\DynamicPerPage;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new SortScope);
        static::addGlobalScope(new SearchScope);
    }
}
