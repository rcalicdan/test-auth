<?php

namespace App\Models;

use Rcalicdan\Ci4Larabridge\Models\Model;

use Rcalicdan\Ci4Larabridge\Traits\Authentication\Authenticable;
use Rcalicdan\Ci4Larabridge\Traits\Authentication\HasEmailVerification;
use Rcalicdan\Ci4Larabridge\Traits\Authentication\HasPasswordReset;
use Rcalicdan\Ci4Larabridge\Traits\Authentication\HasRememberToken;

class User extends Model
{
    use HasEmailVerification,
        HasPasswordReset,
        HasRememberToken,
        Authenticable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }
}
