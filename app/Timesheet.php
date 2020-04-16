<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasAuthors;

    /** @var string */
    const STATUS_CREATED = 'created';

    /** @var string */
    const STATUS_APPROVED = 'approved';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'doing',
        'problem',
        'plan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date'  => 'date',
        'doing' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function notifiers()
    {
        return $this->hasManyThrough(User::class, TimesheetNotify::class);
    }
}
