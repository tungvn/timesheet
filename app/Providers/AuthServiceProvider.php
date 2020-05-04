<?php

namespace App\Providers;

use App\Policies\SettingPolicy;
use App\Policies\TimesheetPolicy;
use App\Policies\UserPolicy;
use App\Setting;
use App\Timesheet;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Setting::class   => SettingPolicy::class,
        Timesheet::class => TimesheetPolicy::class,
        User::class      => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addHours(config('auth.timeout.token')));

        Passport::refreshTokensExpireIn(now()->addHours(config('auth.timeout.refresh_token')));
    }
}
