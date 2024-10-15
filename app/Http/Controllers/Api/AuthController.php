<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    protected $roleHierarchy = [
    "Petugas Jadwal" => [
     "Petugas Cetak Surat Tugas"
    ],
    "Petugas Cetak Surat Tugas" => [
     "Petugas Ukur"
    ],
    "Petugas Ukur" => [
     "Admin Pengukuran"
    ],
    "Admin Pengukuran" => [
     "Koordinator Pengukuran"
    ],
    "Koordinator Pengukuran" => [
     "Admin 1",
     "Admin 3",
     "Koordinator Wilayah",
     "Petugas Jadwal",
     "Petugas Ukur"
    ],
    "Admin 1" => [
     "Petugas Gambar",
     "Koordinator Wilayah",
     "Kasi SP"
    ],
    "Petugas Gambar" => [
     "Koordinator Wilayah",
     "Petugas Ukur",
     "Admin Pengukuran"
    ],
    "Koordinator Wilayah" => [
     "Petugas Gambar",
     "Petugas Ukur",
     "Koordinator Pengukuran",
     "Admin 1",
     "Admin 2",
     "Admin 3",
    ],
    "Admin 2" => [
    "Koordinator Wilayah",
     "Admin Spasial",
     "Koordinator Pengukuran",
     "Kasi SP",
     "Admin 1",
     "Admin 2",
    ],
    "Admin 3" => [
     "Koordinator Wilayah",
     "Admin Spasial",
     "Koordinator Pengukuran",
     "Kasi SP",
     "Admin 1",
     "Admin 2",
    ],
    "Kasi SP" => [
     "Koordinator Wilayah",
     "Koordinator Pengukuran",
     "Admin 1",
     "Admin 2",
     "Admin 3",
    ]
     ];
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request['email'])->first();

        // if(!$user->is_active) {
        //     return $this->respondWithError(403, "Maaf, akun pengguna telah dinonaktifkan.");
        // }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;
        $msg = 'Hi ' . $user->name . ', welcome ';
        $response = $user;
        $user->permissions =
        $user->getPermissionsViaRoles()->map(function ($permission) {
            return $permission['name'];
        });

        if (!Hash::check($request->password, $user->password) || !$user) {
            return $this->respondWithError(ApiCode::UNAUTHORIZED, ApiMessage::UNAUTHORIZED);
        }
        //UPDATE OR CREATE DEVICE TOKEN
        // if ($request->filled('device_token')) {
        //     $condition = ['user_id' => $user->id, 'device' => 'mobile', 'user_agent' => $request->header('User-Agent')]; // Replace 'name' with the column name you want to check
        //     $deviceToken = \App\Models\UserDeviceToken::firstOrNew($condition);
        //     $deviceToken->user_id = $user->id;
        //     $deviceToken->device = 'mobile';
        //     $deviceToken->token =  $request->device_token;
        //     $deviceToken->save();
        // }


        // Get the user's primary role
        $role = $user->getRoleNames()->first();

        // Get roles that this user's role can delegate to
        $dapat_diteruskan_ke_role = $this->getDelegatedRoles($role);


        $data = [
            'user' => $user,
            'token' => $token,
            'dapat_diteruskan_ke_role' => $dapat_diteruskan_ke_role,
        ];

        return $this->respond($data);
    }

    public function profile()
    {
        $user = User::where('id', auth()->user()->getId())->first();

        $user->permissions =
        $user->getPermissionsViaRoles()->map(function ($permission) {
            return $permission['name'];
        });


        // Get the user's primary role
        $role = $user->getRoleNames()->first();
        $user->dapat_diteruskan_ke_role = $this->getDelegatedRoles($role);
        return $this->respond($user);
    }


    protected function getDelegatedRoles($role)
    {

        // If the user is a Super Admin, return all roles from the hierarchy
        if ($role === 'Super Admin') {
            return array_keys($this->roleHierarchy);
        }

        // Return the specific delegated roles for other roles
        return $this->roleHierarchy[$role] ?? [];

    }
}
