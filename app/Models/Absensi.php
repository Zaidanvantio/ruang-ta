<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tanggal',
        'cuti',
        'jam_datang',
        'jam_pulang',
        'jam_kerja',
        'uraian_pekerjaan',
    ];
}