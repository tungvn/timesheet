<?php

namespace App\Providers;

use App\Observers\TimesheetObserver;
use App\Observers\UserObserver;
use App\Timesheet;
use App\Timesheets\Client;
use App\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();

        Passport::useClientModel(\App\Timesheets\Passport\Client::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Timesheet::observe(TimesheetObserver::class);
    }
}
