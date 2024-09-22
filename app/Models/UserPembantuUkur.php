<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPembantuUkur extends Model
{
    use HasFactory;
    protected $table = 'user_pembantu_ukur';


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'pendamping_id');
    }
}
