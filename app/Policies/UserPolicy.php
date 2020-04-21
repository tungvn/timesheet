<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view list models.
     *
     * @param \App\User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return $user->isAdmin();
    }

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
