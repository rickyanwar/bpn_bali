<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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

        $data = [
            'user' => $user,
            'token' => $token
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

        return $this->respond($user);
    }

}
