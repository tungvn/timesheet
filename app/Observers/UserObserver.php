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
     * Trigger user created
     *
     * @param User $user
     */
    public function created(User $user)
    {
        $user->statistic()->create([
            'month' => now()->format('Y-m'),
        ]);
    }

    /**
     * Automatically hash the password in the input data
     *
     * @param User $user
     */
    public function updating(User $user)
    {
        if ($user->isDirty('password')) {
            $user->password = Hash::make($user->password);
        }
    }
}
