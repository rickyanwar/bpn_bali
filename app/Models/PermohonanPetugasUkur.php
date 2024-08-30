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
        'user_id',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
