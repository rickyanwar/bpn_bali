<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;
    protected $table = 'audit_trails';
    protected $fillable = [
        'module_name',
        'module_id',
        'action',
        'created_by',
        'description',
        'created_on'
    ];
    protected $casts = [
        'created_at' => 'date:d-m-Y h:i A',
        'updated_at' => 'date:d-m-Y h:i A',
    ];
    public function createdby()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
