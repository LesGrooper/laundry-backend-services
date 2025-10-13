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
    Schema::create('users_information', function (Blueprint $table) {
        $table->id();
        $table->integer("user_id");
        $table->string('user_image');
        $table->string('user_address');
        $table->string('user_category');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_information');
    }
};
