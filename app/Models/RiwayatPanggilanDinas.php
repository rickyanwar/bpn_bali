<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class RiwayatPanggilanDinas extends Model
{
    use HasFactory;
    protected $table = 'riwayat_panggilan_dinas';

    protected $fillable = [
       'permohonan_id',
       'tanggal_panggil',
       'created_by',
       'catatan',
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'dokumen_terlampir' => 'json'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Makassar')->format('d-m-Y h:i A');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
