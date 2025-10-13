<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable, HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'user_status'
    ];

    protected $hidden = [
        'password',
    ];
}
