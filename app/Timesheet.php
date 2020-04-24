<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Timesheet extends Model
{
    use HasAuthors;

    /** @var string */
    const STATUS_CREATED = 'created';

    /** @var string */
    const STATUS_APPROVED = 'approved';

    /** @var string */
    const STATUS_CHANGED = 'changed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'doing', // Array of \App\Timesheets\Task
        'problem',
        'plan',
        'status',
        'approved_at',
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
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        if ($this->exists) {
            return parent::getFillable();
        }

        return [
            'date',
            'doing', // Array of \App\Timesheets\Task
            'problem',
            'plan',
        ];
    }

    /**
     * @return HasManyThrough
     */
    public function notifiers()
    {
        return $this->hasManyThrough(User::class, TimesheetNotify::class);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeWithLeader(Builder $builder)
    {
        return $builder->whereIn($this->getCreatedByColumn(), auth()->user()->followers->map->id);
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isChanged()
    {
        return $this->status === self::STATUS_CHANGED;
    }
}
