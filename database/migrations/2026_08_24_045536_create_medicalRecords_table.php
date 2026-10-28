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
    Schema::create('medical_records', function (Blueprint $table) {
        $table->id();
        $table->foreignId('registration_id')->unique()->constrained('registrations')->cascadeOnDelete();
        $table->text('keluhan');
        $table->text('diagnosis');
        $table->text('tindakan');
        $table->text('resep_obat')->nullable();
        $table->boolean('perlu_kontrol')->default(false);
        $table->date('tanggal_kontrol')->nullable();
        $table->text('catatan_kontrol')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
