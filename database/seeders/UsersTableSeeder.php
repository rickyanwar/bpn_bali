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
            ['role_name' => "Petugas Cetak", 'user_name' => 'User 1', 'user_email' => 'user1@example.com', 'user_password' => 'password'],
            ['role_name' => "Admin Pengukuran", 'user_name' => 'User 4', 'user_email' => 'user4@example.com', 'user_password' => 'password'],
            ['role_name' => "Koordinator Pengukuran", 'user_name' => 'User 5', 'user_email' => 'user5@example.com', 'user_password' => 'password'],
            ['role_name' => "Petugas Gambar", 'user_name' => 'User 6', 'user_email' => 'user6@example.com', 'user_password' => 'password'],
            ['role_name' => "Koordinator Wilayah", 'user_name' => 'User 7', 'user_email' => 'user7@example.com', 'user_password' => 'password'],
            ['role_name' => "Kasi SP", 'user_name' => 'User 8', 'user_email' => 'user8@example.com', 'user_password' => 'password'],
            ['role_name' => "Petugas Ukur", 'user_name' => 'User 9', 'user_email' => 'user9@example.com', 'user_password' => 'password'],
            ['role_name' => "Admin", 'user_name' => 'User 10', 'user_email' => 'user10@example.com', 'user_password' => 'password'],
        ];

        // Create roles and users
        foreach ($rolesWithUsers as $data) {
            // Create role
            $role = Role::create([
                'name' => $data['role_name'],
                'created_by' => 0,
            ]);

            // Assign permissions to the role
            $role->givePermissionTo([
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

            // Create user
            $user = User::create([
                'name' => $data['user_name'],
                'email' => $data['user_email'],
                'password' => Hash::make($data['user_password']),
                'type' => 'user', // Adjust as needed
                'lang' => 'en',
                'created_by' => 0,
                'email_verified_at' => now(),
            ]);

            // Assign role to user
            $user->assignRole($role);
        }

    }
}
