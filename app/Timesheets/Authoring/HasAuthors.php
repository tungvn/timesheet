<?php

namespace App\Timesheets\Authoring;

use App\User;

/**
 * Trait HasAuthors
 *
 * @package App\Greeta\Authoring
 * @property User $author
 * @property User updater
 */
trait HasAuthors
{
    /**
     * @return void
     */
    public static function bootHasAuthors()
    {
        static::observe(new AuthorObserver);
    }

    /**
     * The user who originally created the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function author()
    {
        return $this->belongsTo(User::class, $this->getCreatedByColumn());
    }

    /**
     * The last person who updated the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function updater()
    {
        return $this->belongsTo(User::class, $this->getUpdatedByColumn());
    }

    /**
     * Get the name of the person who created this entity.
     *
     * @return string
     */
    public function getAuthorNameAttribute()
    {
        if (!$this->{$this->getCreatedByColumn()}) {
            return '';
        }

        return $this->author->name;
    }

    /**
     * Get the name of the person who last updated this entity.
     *
     * @return string
     */
    public function getUpdaterNameAttribute()
    {
        if (!$this->{$this->getUpdatedByColumn()}) {
            return '';
        }

        return $this->updater->name;
    }

    /**
     * Limit results to the owners entities.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null                              $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwnedBy($query, $userId = null)
    {
        return $query->where($this->getCreatedByColumn(), $userId ?? auth()->id());
    }

    /**
     * Check if the given user is the author of this entity.
     *
     * @param User $user
     * @return bool
     */
    public function authorIs(User $user)
    {
        return $this->{$this->getCreatedByColumn()} === $user->id;
    }

    /**
     * Database column name for created by.
     *
     * @return string
     */
    protected function getCreatedByColumn()
    {
        return 'created_by';
    }

    /**
     * Database column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }
}
