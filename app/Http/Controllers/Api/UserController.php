<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $userQuery = User::query();


        // Search for users by name or email
        if ($request->term) {
            $userQuery->where('name', 'LIKE', '%' . $request->term . '%')
                      ->orWhere('email', 'LIKE', '%' . $request->term . '%');
        }


        if ($request->role) {
            $userQuery->whereHas('roles', function ($query) use ($request) {
                $query->where('name', $request->role);
            });
        }

        // Paginate the result with 10 users per page
        $users = $userQuery->paginate(10);

        return $this->respond($users);


    }
}
