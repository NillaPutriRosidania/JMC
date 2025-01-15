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
        Schema::create('tb_kecamatan', function (Blueprint $table) {
            $table->increments('id_kecamatan');
            $table->string('nama_kecamatan', 100)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->longText('geojson')->nullable()->charset('utf8mb4')->collation('utf8mb4_bin');
            $table->text('latitude')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->text('longitude')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kecamatan');
    }
};