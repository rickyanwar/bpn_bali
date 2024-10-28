<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Http\Requests\PermohonanRequest;
use App\Http\Requests\PermohonanDiteruskanRequest;
use App\Models\Utility;
use App\Models\User;
use App\Models\Documents;
use App\Models\AuditTrail;
use App\Models\PermohonanPetugasUkur;
use App\Models\RiwayatPermohonanDiTeruskan;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use App\ApiMessage;
use App\ApiCode;
use Spatie\Permission\Models\Role;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function jadwalPengukuran(Request $request)
    {


        $petugasUkur = User::role('Petugas Ukur')->get();

        // Get the 'tanggal' parameter from the request
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $petugasId = $request->input('petugas_id'); // Get the selected user ID

        // Initialize the query
        $query = Permohonan::with('createdby', 'diteruskan');

        // Check if 'tanggal' contains a range or a single date
        if (strpos($tanggal, 'to') !== false) {
            // Split the range into two dates
            list($startDate, $endDate) = explode('to', $tanggal);
            // Trim any whitespace
            $startDate = trim($startDate);
            $endDate = trim($endDate);

            // Apply the date range filter
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            // Filter by a single date
            $query->whereDate('created_at', $tanggal);
        }


        // Filter by user if selected
        // if (!empty($petugasId)) {
        //     $query->whereHas('petugasUkur', function ($q) use ($petugasId) {
        //         $q->where('id', $petugasId);
        //     });
        // }


        // Add any additional sorting if necessary
        $query->orderByRaw("FIELD(status, 'draft', 'revisi', 'proses', 'selesai')");

        if ($request->ajax()) {
            return DataTables::of($query)
               ->addColumn('petugas_ukur_utama', function ($data) {
                   return $data->petugas_ukur_utama;
               })
                ->addColumn('status_badge', function ($data) {
                    $status = '';
                    switch ($data->status) {
                        case 'draft':
                            $status = 'bg-danger';
                            break;
                        case 'proses':
                            $status = 'bg-warning';
                            break;
                        case 'selesai':
                            $status = 'bg-success';
                            break;
                        default:
                            $status = 'bg-secondary'; // Default class if none of the above statuses match
                            break;
                    }
                    return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                        . __($data->status) . '</span>';
                })
                ->rawColumns(['status_badge', 'actions'])
                ->make(true);
        }

        return view('report.jadwal_pengukuran', compact('petugasUkur'));
    }

    public function jadwalSetorBerkas(Request $request)
    {


        $petugasUkur = User::role('Petugas Ukur')->get();
        $petugasId = $request->input('petugas_id');
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        // Initialize the query
        $query = Permohonan::with('createdby', 'diteruskan');

        // Check if 'tanggal' contains a range or a single date
        if (strpos($tanggal, 'to') !== false) {
            // Split the range into two dates
            list($startDate, $endDate) = explode('to', $tanggal);
            // Trim any whitespace
            $startDate = trim($startDate);
            $endDate = trim($endDate);

            // Apply the date range filter
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } else {
            // Filter by a single date
            $query->whereDate('created_at', $tanggal);
        }



        // // Filter by user if selected
        // if (!empty($petugasId)) {
        //     $query->whereHas('petugasUkur', function ($q) use ($petugasId) {
        //         $q->where('id', $petugasId);
        //     });
        // }


        if ($request->ajax()) {
            return DataTables::of($query)
            ->addColumn('status_badge', function ($data) {
                $status = '';
                switch ($data->status) {
                    case 'draft':
                        $status = 'bg-danger';
                        break;
                    case 'proses':
                        $status = 'bg-warning';
                        break;
                    case 'selesai':
                        $status = 'bg-success';
                        break;
                    default:
                        $status = 'bg-secondary'; // Default class if none of the above statuses match
                        break;
                }
                return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                    . __($data->status) . '</span>';
            })
            ->rawColumns([ 'status_badge', 'actions'])
            ->make(true);
        }

        if ($request->ajax()) {
            return DataTables::of($query)
            ->addColumn('status_badge', function ($data) {
                $status = '';
                switch ($data->status) {
                    case 'draft':
                        $status = 'bg-danger';
                        break;
                    case 'proses':
                        $status = 'bg-warning';
                        break;
                    case 'selesai':
                        $status = 'bg-success';
                        break;
                    default:
                        $status = 'bg-secondary'; // Default class if none of the above statuses match
                        break;
                }
                return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                    . __($data->status) . '</span>';
            })
            ->rawColumns([ 'status_badge', 'actions'])
            ->make(true);
        }

        return view('report.setor_berkas', compact('petugasUkur'));
    }


}
