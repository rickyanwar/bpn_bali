<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Permohonan;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'name',
        'email',
        'password',
        'golongan',
        'jabatan',
        'no_hp',
        'pembantu_ukur_nik',
        'pembantu_ukur_no_sk',
        'nip'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public static $statues = [
        'Active',
        'Deactivate'
    ];

    protected $appends = ['total_pekerjaan'];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getId()
    {
        return $this->id;
    }
    public function permohonansAssigned()
    {
        return $this->hasMany(Permohonan::class, 'diteruskan_ke');
    }

    /**
     * Get the count of pending jobs for the user (where status != 'selesai')
     */
    public function getTotalPekerjaanAttribute()
    {
        return $this->permohonansAssigned()->where('status', '!=', 'selesai')->count();
    }

    protected function getDefaultGuardName(): string
    {
        return 'api';
    }
}
