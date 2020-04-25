<?php

namespace App\Console;

use App\Jobs\NotifyUserLateSubmitTimesheet;
use App\Jobs\NotifyUserSubmitTimesheet;
use App\Setting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $startStartTime = Setting::where('key', config('timesheet.configs.start_time'))->first()->value;
        $startSubmitTime = Setting::where('key', config('timesheet.configs.submit_time'))->first()->value;

        $schedule->job(new NotifyUserSubmitTimesheet())->daily()->at($startStartTime);
        $schedule->job(new NotifyUserLateSubmitTimesheet())->daily()->at($startSubmitTime);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
