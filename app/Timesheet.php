<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'date'  => 'date:Y-m-d',
        'doing' => 'array',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'author',
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
     * @return BelongsToMany
     */
    public function notifiers()
    {
        return $this->belongsToMany(User::class, 'timesheet_notifies')->using(TimesheetNotify::class);
    }

    /**
     * @return HasMany
     */
    public function notifies()
    {
        return $this->hasMany(TimesheetNotify::class);
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

    /**
     * @return bool
     */
    public function isCreated()
    {
        return $this->status === self::STATUS_CREATED;
    }
}
