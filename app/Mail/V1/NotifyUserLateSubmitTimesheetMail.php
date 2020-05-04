<?php

namespace App\Mail\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUserLateSubmitTimesheetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param object|array $to
     */
    public function __construct($to)
    {
        $this->to($to)
            ->from('no-reply@timesheet.test');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.notify-late-submit');
    }
}
