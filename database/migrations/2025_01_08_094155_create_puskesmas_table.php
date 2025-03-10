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
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->bigIncrements('id_puskesmas');
            $table->string('nama_puskesmas', 255)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->unsignedInteger('id_kecamatan');
            $table->text('alamat_puskesmas')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('lat')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('long')->nullable()->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('kecamatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puskesmas');
    }
};