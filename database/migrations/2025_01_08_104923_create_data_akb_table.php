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
        Schema::create('data_akb', function (Blueprint $table) {
            $table->id('id_data_akb');
            $table->unsignedBigInteger('id_puskesmas');
            $table->unsignedBigInteger('id_tahun');
            $table->integer('akb');
            $table->enum('status', ['Sangat rendah', 'Rendah', 'Biasa', 'Tinggi', 'Sangat Tinggi'])->nullable(); // status dengan nilai yang sesuai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_akb');
    }
};