<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoice_details';

    protected $fillable = [
        'invoice_id',
        'service_products_id',
        'quantity',
        'price',
        'subtotal'
    ];

    public $timestamps = true;
}
