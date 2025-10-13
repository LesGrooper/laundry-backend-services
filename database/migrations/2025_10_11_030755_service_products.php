<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('service_products', function (Blueprint $table) {
        $table->id();
        $table->string('service_products_name');
        $table->decimal('service_products_price', 10, 2);
        $table->string('service_products_weight')->comment("Weight in kilogram");
        $table->string('service_products_category');
        $table->integer('products_id');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_products');
    }
};
