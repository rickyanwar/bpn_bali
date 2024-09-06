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

    protected $casts = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'dokumen_terlampir' => 'json'
    ];
    protected $table = 'riwayat_permohonan_diteruskan';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
