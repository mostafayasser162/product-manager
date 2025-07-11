<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SearchScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $table = $builder->getModel()->getTable();
        // dd ($table);

        $request = app('request');

        if (!$request->has('search')) {
            return;
        }
        $search = request()->search;

        $builder->where("$table.name", 'like', '%' . $search . '%')
            ->orWhere("$table.id", 'like', '%' . $search . '%');
    }
}
