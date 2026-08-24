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
    Schema::create('pendaftaran', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pasien_id')
            ->constrained('pasien')
            ->cascadeOnDelete();

        $table->foreignId('jadwal_dokter_id')
            ->constrained('jadwal_dokter')
            ->cascadeOnDelete();

        $table->date('tanggal');
        $table->text('catatan')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
