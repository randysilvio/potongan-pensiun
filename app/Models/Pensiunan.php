<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensiunan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
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
        'status',
    ];
}