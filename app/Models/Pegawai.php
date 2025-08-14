<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pensiunans';

    protected $fillable = [
        'nama_lengkap', // Pastikan kolom ini ada di sini
        'status',
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
    ];
}