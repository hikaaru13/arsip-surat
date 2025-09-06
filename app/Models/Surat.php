<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'nomor_surat','kategori','judul','waktu_pengarsipan','file_path'
    ];

    protected $casts = [
        'waktu_pengarsipan' => 'datetime',
    ];
}
