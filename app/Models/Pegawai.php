<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';

    protected $fillable = [
        'nama_pegawai', // <-- Diperbaiki
        'status',
        'tanggal_lahir'
    ];

    public function potonganTahunan()
    {
        return $this->hasMany(PotonganTahunan::class);
    }
}