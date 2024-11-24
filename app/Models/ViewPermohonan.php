<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewPermohonan extends Model
{
    protected $table = 'view_permohonan'; // Match the name of your view
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'tanggal_mulai_pengukuran' => 'datetime:d-m-Y',
        'tanggal_berakhir_pengukuran' => 'date',
    ];

}
