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
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn([
                'potongan_januari',
                'potongan_februari',
                'potongan_maret',
                'potongan_april',
                'potongan_mei',
                'potongan_juni',
                'potongan_juli',
                'potongan_agustus',
                'potongan_september',
                'potongan_oktober',
                'potongan_november',
                'potongan_desember',
                'status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
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
            $table->string('status')->default('Aktif');
        });
    }
};