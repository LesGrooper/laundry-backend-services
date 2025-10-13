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
    Schema::create('invoice', function (Blueprint $table) {
        $table->id();
        $table->string('invoice_image');
        $table->string('invoice_description')->nullable();
        $table->enum('invoice_status', ['pending', 'process', 'done', 'cancelled'])->default('pending');
        $table->integer('invoice_generated_by')->comment("users_id");
        $table->integer('invoice_owner_id')->comment("customers_id");
        $table->date('invoice_deadline')->nullable()->comment('Tanggal estimasi selesai laundry');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
