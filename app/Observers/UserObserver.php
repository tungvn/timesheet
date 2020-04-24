<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Automatically hash the password in the input data
     *
     * @param User $user
     */
    public function creating(User $user)
    {
        $user->role = User::ROLE_USER;
        if (isset($user->password)) {
            $user->password = Hash::make($user->password);
        }
    }

    /**
     * Automatically hash the password in the input data
     *
     * @param User $user
     */
    public function updating(User $user)
    {
        if (isset($user->password)) {
            $user->password = Hash::make($user->password);
        }
    }
}
