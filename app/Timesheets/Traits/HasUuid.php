<?php

namespace App\Timesheets\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Create a new Eloquent model instance.
     * And setting the key type and incrementing support for UUID
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setKeyType('string');

        $this->setIncrementing(false);
    }

    /**
     * Boot the model and create the uuid
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->{$instance->getKeyName()} = Str::uuid()->toString();
        });
    }
}
