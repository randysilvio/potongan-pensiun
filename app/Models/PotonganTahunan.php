<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotonganTahunan extends Model
{
    use HasFactory;

    protected $table = 'potongan_tahunan';

    protected $fillable = [
        'pegawai_id',
        'tahun',
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

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}