<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeForHrCoordinator(Builder $query): void
    {
        $query->whereNull('hr_coordinator_status');
    }

    public function scopeForHrManager(Builder $query): void
    {
        $query->where('hr_coordinator_status', 'approved')
            ->whereNull('hr_manager_status');
    }
}
