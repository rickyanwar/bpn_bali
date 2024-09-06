<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all 'permohonan' where the status is not 'selesai'
        $permohonan = Permohonan::where('status', '!=', 'selesai')->get();

        // Return data as JSON response
        return response()->json($permohonan);
    }

    public function getListdisplay()
    {

        // Get all roles with users and their total pending jobs count
        $roles = Role::with(['users' => function ($query) {
            $query->get(); // Get all users; total_pekerjaan will be calculated in the model
        }])->get();

        // Map roles and users to include their total_pekerjaan
        $roles->map(function ($role) {
            $role->users = $role->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'total_pekerjaan' => $user->total_pekerjaan, // Access the custom attribute
                ];
            })->sortByDesc('total_pekerjaan'); // Sort users by total_pekerjaan in descending order
        });

        return response()->json($roles);


    }

    public function display()
    {

        return view('dashboard.display');

    }
}
