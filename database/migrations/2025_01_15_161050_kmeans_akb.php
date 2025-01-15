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
        Schema::create('kmeans_akb', function (Blueprint $table) {
            $table->bigIncrements('id_kmeans_akb');
            $table->unsignedInteger('id_kecamatan');
            $table->double('grand_total_akb');
            $table->unsignedBigInteger('id_cluster')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onDelete('cascade');
            $table->foreign('id_cluster')->references('id_cluster')->on('clusters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};