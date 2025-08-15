<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus atau komentari baris ini karena kolom sudah ada
        // Schema::table('pegawais', function (Blueprint $table) {
        //     $table->string('nama_pegawai')->after('id');
        // });
    }

    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropColumn('nama_pegawai');
        });
    }
};