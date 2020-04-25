<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TimesheetNotify extends Pivot
{
    use HasAuthors;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'timesheet_notifies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'timesheet_id',
        'user_id',
    ];
}
