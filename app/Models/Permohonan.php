<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utility;

class Permohonan extends Model
{
    use HasFactory;
    protected $table = 'permohonan';
    protected $fillable = [
        'di_305',
        'di_302',
        'tanggal_pengukuran',
        'no_surat',
        'nama_pemohon',
        'no_berkas',
        'kecamatan',
        'desa',
        'luas',
        'jenis_permohonan',
        'diteruskan_ke',
        'alasan_penolakan',
        'dokumen_terlampir',
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        'dokumen_terlampir' => 'json'
    ];

    public function createdby()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function petugasUkur()
    {
        return $this->hasMany(PermohonanPetugasUkur::class, 'permohonan_id');
    }

    public static function boot()
    {
        parent::boot();
        //while creating/inserting item into db
        static::creating(function ($item) {
            $item->no_surat = Utility::generateCode($item, 'no_surat', null, 10);
            $item->status = "Draft";
            $item->created_by = auth()->user()->id;
        });
    }


    //FOR API
    public function kecamatan()
    {
        return $this->hasOne(\App\Models\WilayahIndonesia::class, 'nama', 'kecamatan');
    }

    //FOR API
    public function desa()
    {
        return $this->hasOne(\App\Models\WilayahIndonesia::class, 'nama', 'desa');
    }
}
