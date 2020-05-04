<?php

namespace App\Jobs;

use App\Mail\V1\NotifyUserLateSubmitTimesheetMail;
use App\Timesheet;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUserLateSubmitTimesheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $usersSubmitted = Timesheet::query()->whereDate('date', now()->format('Y-m-d'))->pluck('created_by');
        User::query()
            ->whereNotIn('id', $usersSubmitted)
            ->pluck('email')
            ->chunk(100)
            ->each(function ($chunkEmails) {
                Mail::queue(new NotifyUserLateSubmitTimesheetMail($chunkEmails));
            });
    }
}
