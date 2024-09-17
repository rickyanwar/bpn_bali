<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanPetugasUkur extends Model
{
    use HasFactory;
    protected $table = 'permohonan_petugas_ukur';

    protected $fillable = [
        'permohonan_id',
        'petugas_ukur',
        'pendamping'
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_ukur');
    }

    public function petugas_pendamping()
    {
        return $this->belongsTo(User::class, 'pendamping');
    }

}
