<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTimesheetStatisticNextMonth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $nextMonth = now()->addMonthNoOverflow()->format('Y-m');
        User::query()->each(function (User $user) use ($nextMonth) {
            $user->statistic()->firstOrCreate([
                'month' => $nextMonth,
            ]);
        });
    }
}
