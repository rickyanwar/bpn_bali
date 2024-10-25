<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utility;
use Carbon\Carbon;

class Permohonan extends Model
{
    use HasFactory;
    protected $table = 'permohonan';
    protected $fillable = [
        'di_305',
        'di_302',
        'tanggal_mulai_pengukuran',
        'tanggal_berakhir_pengukuran',
        'no_surat',
        'nama_pemohon',
        'no_berkas',
        'no_surat_perintah_kerja',
        'kecamatan',
        'desa',
        'luas',
        'jenis_kegiatan',
        'diteruskan_ke',
        'alasan_penolakan',
        'dokumen_terlampir',
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
        // 'tanggal_mulai_pengukuran' => 'date:d-m-Y',
        'dokumen_terlampir' => 'json'
    ];

    protected $appends = ['perlu_diteruskan','petugas_ukur_utama', 'tahun'];

    public function createdby()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function diteruskan()
    {
        return $this->belongsTo(\App\Models\User::class, 'diteruskan_ke');
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
            $item->status = "draft";
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


    public function riwayat()
    {
        return $this->hasMany(RiwayatPermohonanDiTeruskan::class, 'permohonan_id');
    }


    public function riwayatPanggilanDinas()
    {
        return $this->hasMany(RiwayatPanggilanDinas::class, 'permohonan_id');
    }
    public function auditTrails()
    {

        return $this->hasMany(\App\Models\AuditTrail::class, 'module_id')->where('module_name', 'Permohonan');

    }


    public function getPerluDiteruskanAttribute()
    {
        // Get the latest RiwayatPermohonanDiTeruskan record
        $latestRiwayat = $this->riwayat()->latest()->first();
        // Check if there's a day of penerusan more than > 2 day
        if ($latestRiwayat) {
            $isMoreThanTwoDaysOld = $latestRiwayat->created_at->lt(Carbon::now()->subDays(2));
            $statusIsNotSelesai = $latestRiwayat->status !== 'selesai';

            return $isMoreThanTwoDaysOld && $statusIsNotSelesai;
        }

        return false;
    }


    public function getPetugasUkurUtamaAttribute()
    {

        $petugas = $this->petugasUkur()->first()->petugas ?? null;

        if ($petugas) {
            $fullName = $petugas->name ?? '-';
            $firstName = explode(' ', $fullName)[0];
            return $firstName;
        }

        return '-';

    }

    public function getTahunAttribute()
    {
        return $this->created_at ? $this->created_at->format('Y') : '-';
    }
}
