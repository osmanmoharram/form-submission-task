<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeForHRCoordinator(Builder $query): Builder
    {
        return $query->whereNull('hr_coordinator_approval')
            ->orWhere('hr_coordinator_approval', 'rejected');
    }

    public function scopeForHRManager(Builder $query): Builder
    {
        return $query->where('hr_coordinator_approval', 'approved')
            ->where(function (Builder $query) {
                $query->whereNull('hr_manager_approval')
                    ->orWhere('hr_manager_approval', 'rejected');
            });
    }
}
