<?php

namespace App\Models;

use App\Models\Scopes\ForRole;
use App\Models\Scopes\ForRoleScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(ForRoleScope::class)]
class FormSubmit extends Model
{
    use HasFactory;

    protected $guarded = [];
}
