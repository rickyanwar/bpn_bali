<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKeterlambatan extends Model
{
    protected $table = 'riwayat_keterlambatan';
    protected $fillable = [
        'permohonan_id',
        'user_id',
        'start_date',
        'tanggal_mulai_pengukuran',
        'tanggal_keterlambatan',
        'tanggal_dialihkan',
        'diteruskan_ke_role',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
