<?php

namespace Database\Seeders;

use App\Models\ExperienceCertificate;
use App\Models\GenerateOfferLetter;
use App\Models\JoiningLetter;
use App\Models\NOC;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define permissions
        $arrPermissions = [
            [
                'name' => 'show all permohonan',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'show permohonan',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit permohonan',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete permohonan',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'teruskan permohonan',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'name' => 'manage user',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'show user',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit user',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete user',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'manage role',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'show role',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'edit role',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'delete role',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        // Insert permissions
        Permission::insert($arrPermissions);

        // Define roles and corresponding users
        $rolesWithUsers = [
            [
                'role_name' => "Petugas Jadwal",
                'user_name' => 'Priskha Primamayanti',
                'user_email' => 'priskha.primamayanti@example.com',
                'user_password' => 'password',
            ],
            [
                'role_name' => "Petugas Cetak Surat Tugas",
                'user_name' => 'Indah Corry',
                'user_email' => 'indah.corry@example.com',
                'user_password' => 'password',
            ],
            // Petugas Ukur
            [
                'role_name' => "Petugas Ukur",
                'user_name' => 'I Ketut Indiana',
                'user_email' => 'ketut.indiana@example.com',
                'user_password' => 'password',
            ],
            [
                'role_name' => "Petugas Ukur",
                'user_name' => 'Prima Hidayatulloh',
                'user_email' => 'prima.hidayatulloh@example.com',
                'user_password' => 'password',
            ],
            [
                'role_name' => "Petugas Ukur",
                'user_name' => 'Ali Nur Chamid',
                'user_email' => '1',
                'user_password' => 'password',
            ],
            // Pembantu Ukur
            [
                'role_name' => "Pembantu Ukur",
                'user_name' => 'IKadek Andi Pramana',
                'user_email' => 'pembantu.ukur1@example.com',
                'user_password' => 'password',
            ],
            // Admin Pengukuran
            [
                'role_name' => "Admin Pengukuran",
                'user_name' => 'Galung Pringga',
                'user_email' => 'galung.pringga@example.com',
                'user_password' => 'password'
            ],
            // Koordinator Pengukuran
            [
                'role_name' => "Koordinator Pengukuran",
                'user_name' => 'I Made Agus Iwan Setiawan',
                'user_email' => 'madeagus.iwansetiawan@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Koordinator Pengukuran",
                'user_name' => 'Bayu Respati',
                'user_email' => 'bayu.respati@example.com',
                'user_password' => 'password'
            ],
            // Petugas Gambar
            [
                'role_name' => "Petugas Gambar",
                'user_name' => 'Agung Pratama',
                'user_email' => 'agung.pratama@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Petugas Gambar",
                'user_name' => 'Dian Pradnya',
                'user_email' => 'dian.pradnya@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Petugas Gambar",
                'user_name' => 'Febbry Wendra',
                'user_email' => 'febbry.wendra@example.com',
                'user_password' => 'password'
            ],
            // Koordinator Wilayah
            [
                'role_name' => "Koordinator Wilayah",
                'user_name' => 'K. Dwi Wahyu Ksmawan',
                'user_email' => 'dwiwahyu.ksmawan@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Koordinator Wilayah",
                'user_name' => 'Wahyu Aji Anindya Wicaksana',
                'user_email' => 'anindya.wicaksana@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Koordinator Wilayah",
                'user_name' => 'Danny Indra Permana',
                'user_email' => 'danny.permana@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Koordinator Wilayah",
                'user_name' => 'Putu Swandewi',
                'user_email' => 'putu.swandewi@example.com',
                'user_password' => 'password'
            ],
            // Kasi SP
            [
                'role_name' => "Kasi SP",
                'user_name' => 'Darmansyah',
                'user_email' => 'darmansyah@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Admin 1",
                'user_name' => 'I Wayan Agus Karyawan',
                'user_email' => 'wayan.aguskaryawan9@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Admin 2",
                'user_name' => 'Irma Ristiadewi',
                'user_email' => 'irma.ristiadewi@example.com',
                'user_password' => 'password'
            ],
            [
                'role_name' => "Admin 3",
                'user_name' => 'Dian Indri',
                'user_email' => 'dian.indri@example.com',
                'user_password' => 'password'
            ],
        ];

        // Create roles and users
        foreach ($rolesWithUsers as $data) {
            // Check if the role exists, or create it
            $role = Role::firstOrCreate(
                ['name' => $data['role_name']],
                ['created_by' => 0]
            );

            // Check if the user exists, or create it
            $user = User::firstOrCreate(
                ['email' => $data['user_email']],
                [
                    'name' => $data['user_name'],
                    'password' => Hash::make($data['user_password']),
                    'type' => 'user',
                    'lang' => 'en',
                    'created_by' => 0,
                    'email_verified_at' => now(),
                ]
            );

            // Assign role to user only if they don't already have it
            if (!$user->hasRole($role->name)) {
                $user->assignRole($role);
            }

            // Assign permissions to the role (to avoid duplicates)
            $role->syncPermissions([
                'show all permohonan',
                'show permohonan',
                'edit permohonan',
                'delete permohonan',
                'teruskan permohonan',
                'manage role',
                'show role',
                'edit role',
                'delete role',
                'manage user',
                'show user',
                'edit user',
                'delete user',
            ]);
        }

    }

}
