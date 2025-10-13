<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'customers_id',
        'products_name',
        'products_price',
        'products_description',
        'products_image'
    ];
}
