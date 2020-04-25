<?php

namespace App;

use App\Timesheets\Authoring\HasAuthors;
use App\Timesheets\Traits\HasUuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
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
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'role' => self::ROLE_USER,
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
     * @return array
     */
    public function getFillable()
    {
        if (!$this->exists || $this->isAdmin()) {
            return parent::getFillable();
        }

        return [
            'password',
            'avatar',
            'description',
        ];
    }

    /**
     * @return array
     */
    public function getMeUpdateRules()
    {
        if ($this->isAdmin()) {
            return [
                'username'    => [
                    'sometimes',
                    'string',
                    'min:3',
                    'alpha_num',
                    Rule::unique('users')->ignore($this->id),
                ],
                'email'       => [
                    'sometimes',
                    'email',
                    Rule::unique('users')->ignore($this->id),
                ],
                'password'    => 'sometimes|string|min:8|confirmed',
                'leader_id'   => 'nullable|uuid|exists:users,id',
                'avatar'      => 'nullable|string',
                'description' => 'nullable|string',
            ];
        }

        return [
            'avatar'      => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    /**
     * This user belongs to a leader
     *
     * @return BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(self::class);
    }


    /**
     * This user has many followers
     *
     * @return HasMany
     */
    public function followers()
    {
        return $this->hasMany(self::class, 'leader_id');
    }

    /**
     * This user has many timesheets
     *
     * @return HasMany
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
     * @return User
     */
    public function findForPassport(string $username)
    {
        return $this->where('username', $username)->first();
    }
}
