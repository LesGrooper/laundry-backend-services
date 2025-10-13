<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('service_products_id');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->index(['invoice_id', 'service_products_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
