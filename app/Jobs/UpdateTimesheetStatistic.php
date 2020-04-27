<?php

namespace App\Jobs;

use App\Setting;
use App\Timesheet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTimesheetStatistic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Timesheet */
    public $timesheet;

    /**
     * Create a new job instance.
     *
     * @param Timesheet $timesheet
     */
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $month = now()->format('Y-m');
        $user = $this->timesheet->author;

        $statistic = $user->statistic()->firstOrCreate([
            'user_id' => $user->id,
            'month'   => $month,
        ]);

        $data = [
            'submit_times' => ++$statistic->submit_times,
        ];

        $startSubmitTime = Setting::where('key', config('timesheet.configs.submit_time'))->first()->value;
        if (now()->format('H:m') > $startSubmitTime) {
            $data = [
                'late_submit_times' => ++$statistic->late_submit_times,
            ];
        }

        $statistic->update($data);
    }
}
