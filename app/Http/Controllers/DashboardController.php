<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use App\Models\Permohonan;
use Carbon\Carbon;
use DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Handle the date input to set start and end dates
        $tanggal = $request->input('tanggal');
        if (empty($tanggal)) {
            $startDate = Carbon::today()->subMonth()->toDateString();  // Default: past month
            $endDate = Carbon::today()->toDateString();
        } elseif (strpos($tanggal, 'to') !== false) {
            // If input contains 'to', split into start and end dates
            list($startDate, $endDate) = explode('to', $tanggal);
            $startDate = trim($startDate);
            $endDate = trim($endDate);
        } else {
            // If single date, use it as both start and end
            $startDate = $endDate = $tanggal;
        }

        // Adjust queries to use the determined start and end dates
        $totalPermohonan = Permohonan::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalDiproses = Permohonan::where('status', 'proses')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalrevisi = Permohonan::where('status', 'tolak')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalSelesai = Permohonan::where('status', 'selesai')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Totals by status within the date range
        $totalByStatus = Permohonan::with('createdby', 'diteruskan')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $totalAll = $totalByStatus->sum('total');

        // Respond with JSON for AJAX or render the view
        if ($request->ajax()) {
            return response()->json([
                'totalByStatus' => $totalByStatus,
                'totalAll' => $totalAll,
                'totalPermohonan' => $totalPermohonan,
                'totalDiproses' => $totalDiproses,
                'totalrevisi' => $totalrevisi,
                'totalSelesai' => $totalSelesai
            ]);
        }

        return view('dashboard.index', compact('totalPermohonan', 'totalDiproses', 'totalrevisi', 'totalSelesai'));
    }

    public function getListdisplay()
    {
        // Filter roles by 'Petugas Gambar' and 'Petugas Ukur'
        $roles = Role::with(['users' => function ($query) {
            $query->with(['permohonansAssigned' => function ($q) {
                $q->where('status', '!=', 'selesai'); // Get only non-completed permohonan
            }]);
        }])->whereIn('name', ['Petugas Gambar', 'Petugas Ukur'])
        ->get();

        // Map roles and users to include their total_pekerjaan and filter based on perlu_diteruskan
        $roles->map(function ($role) {
            $role->users = $role->users->map(function ($user) {

                $filteredPermohonans = $user->permohonansAssigned->filter(function ($permohonan) {
                    return $permohonan->perlu_diteruskan;
                });

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'total_pekerjaan' => $filteredPermohonans->count(), // Count only permohonan with perlu_diteruskan = true
                ];
            })->sortByDesc('total_pekerjaan'); // Sort users by total_pekerjaan in descending order
        });

        return response()->json($roles);
    }


    public function getPemohonToday()
    {
        $today = Carbon::today();

        $namaPemohonToday = Permohonan::whereDate('created_at', $today)
                                         ->pluck('nama_pemohon');
        return response()->json($namaPemohonToday);
    }


    public function getPemohonPanggilanDinasToday()
    {

        $today = Carbon::today();
        $namaPemohonToday = Permohonan::whereHas('riwayatPanggilanDinas', function ($query) use ($today) {
            $query->whereDate('tanggal_panggil', $today);
        })->get();

        return response()->json($namaPemohonToday);
    }


    public function berkasCount()
    {
        $berkasSelesaiCount = Permohonan::where('status', 'selesai')->count();
        $berkasMasukCount = Permohonan::where('status', '!=', 'selesai')->count();

        return response()->json([
            'berkas_selesai' => $berkasSelesaiCount,
            'berkas_masuk' => $berkasMasukCount,
        ]);
    }

    public function dashboardTable(Request $request)
    {


        $petugasId = $request->input('petugas_id');
        $tanggal = $request->input('tanggal');

        $query = Permohonan::with('createdby', 'diteruskan');

        // Default range to one month if no date is selected
        if (empty($tanggal)) {
            $startDate = Carbon::today()->subMonth()->toDateString();
            $endDate = Carbon::today()->toDateString();
        } elseif (strpos($tanggal, 'to') !== false) {
            list($startDate, $endDate) = explode('to', $tanggal);
            $startDate = trim($startDate);
            $endDate = trim($endDate);
        } else {
            $startDate = $endDate = $tanggal;
        }

        // Apply date filter
        $query->whereBetween('tanggal_mulai_pengukuran', [$startDate, $endDate]);

        // Filter by user if selected
        if (!empty($petugasId)) {
            $query->whereHas('petugasUkur', function ($q) use ($petugasId) {
                $q->where('petugas_ukur', $petugasId);
            });
        }

        // Return as DataTables response
        if ($request->ajax()) {
            return DataTables::of($query)
                ->addColumn('status_badge', function ($data) {
                    $statusClass = match ($data->status) {
                        'draft' => 'bg-danger',
                        'proses' => 'bg-warning',
                        'selesai' => 'bg-success',
                        default => 'bg-secondary',
                    };
                    return '<span class="status_badge badge p-2 px-3 rounded ' . $statusClass . '">'
                        . __($data->status) . '</span>';
                })
                ->rawColumns(['status_badge'])
                ->make(true);
        }

        return view('dashboard.index');


    }

    public function display()
    {
        return view('dashboard.display');
    }
}
