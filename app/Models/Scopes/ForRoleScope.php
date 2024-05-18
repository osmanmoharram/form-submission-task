<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ForRoleScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /** @var User */
        $user = auth()->user();

        $user->hasRole('hr_coordinator')
            ? $builder->whereNull('hr_coordinator_status') 
            : ($user->hasRole('hr_manager')
                ? $builder->where('hr_coordinator_status', 'approved')
                    ->whereNull('hr_manager_status')
                : null);
    }
}
