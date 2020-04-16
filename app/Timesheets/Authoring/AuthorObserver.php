<?php

namespace App\Timesheets\Authoring;

use Illuminate\Database\Eloquent\Model;

class AuthorObserver
{
    /**
     * Associate the model with the creator.
     *
     * @param Model $model
     */
    public function creating(Model $model)
    {
        if (auth()->check()) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        }
    }

    /**
     * Update the model with the last updater.
     *
     * @param Model $model
     */
    public function updating(Model $model)
    {
        if (!$model->isDirty('updated_by')) {
            $model->updated_by = auth()->check() ? auth()->id() : null;
        }
    }
}
