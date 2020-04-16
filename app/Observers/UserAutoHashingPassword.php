<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserAutoHashingPassword
{
    /**
     * Automatically hash the password in the input data
     *
     * @param \App\User $user
     */
    public function creating(User $user)
    {
        if (isset($user->password)) {
            $user->password = Hash::make($user->password);
        }
    }
}
