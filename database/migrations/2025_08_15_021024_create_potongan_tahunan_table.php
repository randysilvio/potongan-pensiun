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
        Schema::create('potongan_tahunan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('potongan_januari', 15, 2)->default(0.00);
            $table->decimal('potongan_februari', 15, 2)->default(0.00);
            $table->decimal('potongan_maret', 15, 2)->default(0.00);
            $table->decimal('potongan_april', 15, 2)->default(0.00);
            $table->decimal('potongan_mei', 15, 2)->default(0.00);
            $table->decimal('potongan_juni', 15, 2)->default(0.00);
            $table->decimal('potongan_juli', 15, 2)->default(0.00);
            $table->decimal('potongan_agustus', 15, 2)->default(0.00);
            $table->decimal('potongan_september', 15, 2)->default(0.00);
            $table->decimal('potongan_oktober', 15, 2)->default(0.00);
            $table->decimal('potongan_november', 15, 2)->default(0.00);
            $table->decimal('potongan_desember', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potongan_tahunan');
    }
};