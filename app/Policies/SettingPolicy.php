<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view list models.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update model.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->isAdmin();
    }
}
