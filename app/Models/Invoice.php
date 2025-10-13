<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
        'invoice_number',
        'invoice_image',
        'invoice_description',
        'invoice_status',
        'invoice_generated_by',
        'invoice_owner_id',
        'invoice_deadline',
        'service_products_id',
    ];
}
