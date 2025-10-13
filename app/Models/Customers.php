<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'customers_name',
        'customers_address',
        'customers_phone_number',
        'customers_image'
    ];
}
