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

        $query = Permohonan::with('createdby', 'diteruskan')
            ->whereDate('created_at', Carbon::today()) // Adjust 'created_at' to your actual date field
            ->orderByRaw("FIELD(status, 'draft', 'revisi', 'proses', 'selesai')");

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

        return view('report.jadwal_pengukuran');
    }

    public function jadwalSetorBerkas(Request $request)
    {


        $query = Permohonan::with('createdby', 'diteruskan')
                   ->orderByRaw("FIELD(status, 'draft', 'revisi', 'proses', 'selesai')");

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

        return view('report.setor_berkas');
    }


}