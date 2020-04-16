<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasAuthors;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];
}
