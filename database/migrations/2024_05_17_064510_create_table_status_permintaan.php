<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('table_status_permintaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permintaan_id');
            // Adding the new datetime columns
            $table->dateTime('onproses')->nullable();
            $table->dateTime('pending')->nullable();
            $table->dateTime('selesai')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            // foreign key
            $table->foreign('permintaan_id')->references('id')->on('table_permintaan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_status_permintaan');
    }
};
