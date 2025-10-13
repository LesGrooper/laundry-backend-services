<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProducts extends Model
{
    protected $table = 'service_products';

    protected $fillable = [
        'service_products_name',
        'service_products_price',
        'service_products_weight',
        'service_products_category',
        'products_id'
    ];
}
