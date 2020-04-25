<?php

use Illuminate\Database\Seeder;

class CreateSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->settings()->each(function ($setting) {
            \App\Setting::create($setting);
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function settings()
    {
        return collect([
            [
                'key'   => config('timesheet.configs.start_time'),
                'value' => config('timesheet.defaults.start_time', '17:00'),
            ],
            [
                'key'   => config('timesheet.configs.submit_time'),
                'value' => config('timesheet.defaults.submit_time', '19:00'),
            ],
        ]);
    }
}
