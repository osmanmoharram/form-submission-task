<?php

namespace App\Policies;

use App\Models\FormSubmit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FormSubmitPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->hasAnyRole(['hr_coordinator', 'hr_manager'])) {
            $this->allow();
        }

        return $this->denyWithStatus(403, 'You are not allowed!');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FormSubmit $formSubmit): Response
    {
        if ($user->hasAnyRole(['hr_coordinator', 'hr_manager'])) {
            $this->allow();
        }

        return $this->denyWithStatus(403, 'You are not allowed!');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FormSubmit $formSubmit): Response
    {
        if ($user->hasAnyRole(['hr_coordinator', 'hr_manager'])) {
            $this->allow();
        }

        return $this->denyWithStatus(403, 'You are not allowed!');
    }
}
