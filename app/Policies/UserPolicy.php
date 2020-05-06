<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view their profile.
     *
     * @param \App\User $user
     * @return bool
     */
    public function me(User $user)
    {
        return $user->id === auth()->id();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @return bool
     */
    public function updateMe(User $user)
    {
        return $user->id === auth()->id();
    }
}
