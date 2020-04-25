<?php

namespace App\Mail\V1;

use App\Timesheet;
use App\TimesheetNotify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TimesheetNotifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var Timesheet */
    public $timesheet;

    /**
     * Create a new message instance.
     *
     * @param Timesheet $timesheet
     */
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(($this->timesheet->isChanged() ?
                'Timesheet has modified by ' : 'Timesheet has added by '
            ) . $this->timesheet->getAuthorNameAttribute())
            ->from('no-reply@timesheet.test')
            ->to($this->timesheet->notifiers->map->email);

        return $this->markdown('emails.timesheet.notify');
    }
}
