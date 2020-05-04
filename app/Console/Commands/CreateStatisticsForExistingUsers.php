<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CreateStatisticsForExistingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create this month statistic for current user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentMonth = now()->format('Y-m');
        User::query()->each(function (User $user) use ($currentMonth) {
            $month = $user->created_at->format('Y-m');
            while ($month <= $currentMonth) {
                $user->statistic()->firstOrCreate([
                    'month' => $month,
                ]);

                $month = Carbon::parse($month)->addMonthNoOverflow()->format('Y-m');
            }
        });
    }
}
