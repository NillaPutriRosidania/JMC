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
        Schema::create('data_aki', function (Blueprint $table) {
            $table->bigIncrements('id_data_aki');
            $table->unsignedBigInteger('id_puskesmas');
            $table->unsignedInteger('id_kecamatan');
            $table->unsignedBigInteger('id_tahun');
            $table->integer('aki');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreign('id_puskesmas')->references('id_puskesmas')->on('puskesmas')->onDelete('cascade');
            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onDelete('cascade');
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_aki');
    }
};