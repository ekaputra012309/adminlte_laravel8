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
        Schema::create('table_permintaan', function (Blueprint $table) {
            $table->id();
            $table->string('pelapor');
            $table->text('kendala');
            $table->unsignedBigInteger('kategori_id');
            $table->enum('tingkat', ['Mudah', 'Sedang', 'Sulit'])->index();
            $table->unsignedBigInteger('lokasi_id');
            $table->enum('status', ['Belum Proses', 'On Proses', 'Pending', 'Selesai'])->default('Belum Proses');
            $table->text('keterangan')->nullable();
            $table->text('solusi')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // foreign key
            $table->foreign('kategori_id')->references('id')->on('master_kategori');
            $table->foreign('lokasi_id')->references('id')->on('master_lokasi');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_permintaan');
    }
};
