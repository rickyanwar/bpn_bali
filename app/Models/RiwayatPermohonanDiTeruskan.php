<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPermohonanDiTeruskan extends Model
{
    use HasFactory;
    protected $fillable = [
        'permohonan_id',
        'user_id',
        'diteruskan_ke',
        'opsi'
    ];
    protected $table = 'riwayat_permohonan_diteruskan';
}
