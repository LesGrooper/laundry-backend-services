<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInformation extends Model
{
    protected $table = 'users_information';

    protected $fillable = [
        'user_id',
        'user_image',
        'user_address',
        'user_category'
    ];
}
