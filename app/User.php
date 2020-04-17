<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use App\Timesheets\Traits\HasUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasUuid, HasApiTokens, HasAuthors, SoftDeletes;

    /** @var string */
    const ROLE_ADMIN = 'admin';

    /** @var string */
    const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'leader_id',
        'role',
        'avatar',
        'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * This user belongs to a leader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * This user has many timesheets
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'created_by');
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * @param string $username
     * @return \App\User
     */
    public function findForPassport(string $username)
    {
        if (filter_var($username, FILTER_SANITIZE_EMAIL)) {
            return $this->where('email', $username)->first();
        }

        return $this->where('username', $username)->first();
    }
}
