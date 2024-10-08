<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $currentUserId = Auth::user()->id;

        // Fetch totals by status
        $totalByStatus = Permohonan::with('createdby', 'diteruskan')
            // ->where(function ($q) use ($currentUserId) {
            //     $q->where('diteruskan_ke', 'like', "%{$currentUserId}%")
            //       ->orWhere('created_by', $currentUserId);
            // })
            ->select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Calculate total count of all applications for the current user
        $totalAll = $totalByStatus->sum('total');

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'totalByStatus' => $totalByStatus,
                'totalAll' => $totalAll
            ]);
        }

        // If it's not an AJAX request, return the view
        return view('dashboard.index', compact('totalByStatus', 'totalAll'));

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
