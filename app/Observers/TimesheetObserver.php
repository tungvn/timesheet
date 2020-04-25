<?php

namespace App\Observers;

use App\Mail\V1\TimesheetNotifyMail;
use App\Timesheet;
use Illuminate\Support\Facades\Mail;

class TimesheetObserver
{
    /**
     * Trigger when creating
     *
     * @param Timesheet $timesheet
     */
    public function creating(Timesheet $timesheet)
    {
        $timesheet->status = Timesheet::STATUS_CREATED;
    }

    /**
     * Trigger when created
     *
     * @param Timesheet $timesheet
     */
    public function created(Timesheet $timesheet)
    {
        if (!is_null($leaderId = $timesheet->author->leader_id)) {
            $timesheet->notifies()->create([
                'user_id' => $leaderId,
            ]);

            Mail::queue(new TimesheetNotifyMail($timesheet));
        }
    }

    /**
     * Trigger when updating
     *
     * @param Timesheet $timesheet
     */
    public function updating(Timesheet $timesheet)
    {
        if ($timesheet->isDirty('status') && $timesheet->isApproved()) {
            $timesheet->approved_at = now();
        }

        if ($timesheet->isDirty() && $timesheet->getOriginal('status') === Timesheet::STATUS_APPROVED) {
            $timesheet->status = Timesheet::STATUS_CHANGED;
        }
    }

    /**
     * Trigger when updated
     *
     * @param Timesheet $timesheet
     */
    public function updated(Timesheet $timesheet)
    {
        if ($timesheet->wasChanged('status') && $timesheet->isChanged()) {
            Mail::queue(new TimesheetNotifyMail($timesheet));
        }
    }
}
