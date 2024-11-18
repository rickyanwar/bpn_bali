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
use App\Models\RiwayatPanggilanDinas;
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
use DB;

class PermohonanController extends Controller
{
    protected $modulName = 'Permohonan';
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
        "Koordinator Pengukuran",
        "Kasi SP",
        "Admin 1",
        "Admin 3",
    ],
    "Admin 3" => [
        "Koordinator Wilayah",
        "Koordinator Pengukuran",
        "Kasi SP",
        "Admin 1",
        "Admin 2",
        "Petugas Jadwal",
        "PHP"
    ],
    "Kasi SP" => [
        "Koordinator Wilayah",
        "Koordinator Pengukuran",
        "Admin 1",
        "Admin 2",
        "Admin 3",
    ],
    "PHP" => []


        ];

    /**
     * Display a listing of the resource.
     */

    //Tugas
    public function index(Request $request)
    {

        // Get the logged-in user
        $user = Auth::user();
        $roles = Role::all();
        $totalPermohonan = Permohonan::where('diteruskan_ke', $user->id)
        // ->where('status', '!=', 'draft')
        ->count();

        $totalPermohonan += Permohonan::where('created_by', $user->id)->whereNull('diteruskan_ke')
        ->count();

        $totalDiproses = Permohonan::where('diteruskan_ke', $user->id)
            ->where('status', 'proses')
            ->count();

        $totalrevisi = Permohonan::where('diteruskan_ke', $user->id)
            ->where('status', 'tolak')
            ->count();

        $totalSelesai = Permohonan::where('diteruskan_ke', $user->id)
            ->where('status', 'selesai')
            ->count();

        // Get the currently authenticated user's ID
        $currentUserId = Auth::id();

        // if (!empty($request->date)) {
        //     dd($request->date);
        // }


        $query = Permohonan::with('createdby', 'diteruskan')
                ->where(function ($q) {
                    $currentUserId = auth()->id();
                    $q->where(function ($subQuery) use ($currentUserId) {
                        // If diteruskan_ke is not null, it must match the current user
                        $subQuery->whereNotNull('diteruskan_ke')
                                ->where('diteruskan_ke', $currentUserId);
                    })
                    ->orWhere(function ($subQuery) use ($currentUserId) {
                        // If diteruskan_ke is null, show records where created_by is the current user
                        $subQuery->whereNull('diteruskan_ke')
                                ->where('created_by', $currentUserId);
                    });
                });
        // ->where('status', '!=', 'selesai')

        // Filter by status if provided
        if (!empty($request->status)) {
            $query =   $query->where('status', '=', $request->status);
        }

        // Filter by tanggal if provided
        if (!empty($request->tanggal)) {
            $tanggal = $request->tanggal;
            if (strpos($tanggal, 'to') !== false) {
                // Split the range into two dates
                list($startDate, $endDate) = explode('to', $tanggal);
                $startDate = trim($startDate);
                $endDate = trim($endDate);

                // Apply the date range filter
                $query =  $query->whereBetween('tanggal_mulai_pengukuran', [$startDate, $endDate]);
            } else {
                $query =  $query->whereDate('tanggal_mulai_pengukuran', $tanggal);
            }

        }



        if (!empty($request->perlu_diteruskan) &&  intval($request->perlu_diteruskan) > 0) {
            $query =  $query->get()->filter(function ($item) {
                return $item->perlu_diteruskan;
            });

        }


        $query = $query->orderBy('tanggal_mulai_pengukuran', 'DESC');


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
            })->addColumn('nota_dinas_badge', function ($data) {
                $status = '';
                if ($data->nota_dinas) {
                    $status = 'bg-danger';
                    return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                        . __('Nota Dinas') . '</span>';
                } else {
                    return '';
                }
            })->addColumn('actions', function ($data) {
                $actions = '';
                // Edit
                if (($data->status == 'draft') || $data->diteruskan_ke == auth()->user()->id) {
                    $actions .= '<div class="action-btn bg-primary ms-2">
                                            <a href="' . route('permohonan.edit', $data->id) . '"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-bs-toggle="tooltip" title="' . __('Edit') . '"
                                                data-original-title="' . __('Edit') . '">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>';
                }



                $actions .= '<div class="action-btn bg-success ms-2 btn_print" data-id="'. $data->id .'" >
                                            <a  href="#" data-url="' . route('permohonan.print_view', $data->id) . '"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-size="md"
                                                data-ajax-popup="true"
                                                data-bs-toggle="tooltip" title="' . __('Print') . '"
                                                data-original-title="' . __('Print') . '">
                                                <i class="ti ti-printer text-white"></i>
                                            </a>
                                        </div>';


                if (Gate::check('alihkan permohonan') && $data->status !== 'draft') {
                    $actions .= '<div class="action-btn bg-warning ms-2 paksa_dialihkan_ke" data-id="'. $data->id .'" >
                                            <a  href="#" data-url="' . route('permohonan.pindah_tugas', $data->id) . '"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-size="md"
                                                data-ajax-popup="true"
                                                data-bs-toggle="tooltip" title="' . __('Alihkan Penugasan') . '"
                                                data-original-title="' . __('Alihkan Penugasan') . '">
                                                <i class="ti ti-report text-white"></i>
                                            </a>
                                        </div>';
                }

                if (Auth::user()->id == $data->diteruskan_ke || (Auth::user()->id == $data->created_by && $data->status == 'draft')) {
                    $actions .= '<div class="action-btn bg-primary ms-2 btn_teruskan" data-id="'. $data->id .'" >
                                            <a  href="#" data-url="' . route('permohonan.teruskan_view', $data->id) . '"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-size="md"
                                                data-ajax-popup="true"
                                                data-bs-toggle="tooltip" title="' . __('Teruskan Penugasan') . '"
                                                data-original-title="' . __('Teruskan Penugasan') . '">
                                                <i class="ti ti-send text-white"></i>
                                            </a>
                                        </div>';
                }


                if ($data->status !== 'draft' &&
                                $data->status !== 'selesai' &&
                                $data->status !== 'revisi' &&
                                $data->diteruskan_ke == auth()->user()->id) {

                    $actions .= '<div class="action-btn bg-warning ms-2 btn-reject" data-id="'. $data->id .'" data-url="' . route('permohonan.tolak', $data->id) . '">
                                            <a  href="#"
                                                data-original-title="' . __('Revisi/Tolak') . '"
                                                class="mx-3 btn btn-sm align-items-center">
                                                    <i class="ti ti-ban text-white"></i>
                                            </a>
                                        </div>';
                }


                if ($data->diteruskan_ke == auth()->user()->id ||
                                ($data->status == 'draft' && auth()->user()->hasRole('Petugas Jadwal')) ||
                                ($data->status == 'revisi' && auth()->user()->id == $data->diteruskan_ke)) {
                }

                // Delete
                if (Auth::user()->can('delete permohonan') && $data->status == 'draft') {
                    $actions .= '<div class="action-btn bg-danger ms-2 btn-delete" data-url="'.route('permohonan.destroy', $data->id) .'">
                                            <a  href="#"
                                                data-original-title="' . __('Hapus') . '"
                                                class="mx-3 btn btn-sm align-items-center">
                                                    <i class="ti ti-trash text-white"></i>
                                            </a>
                                        </div>';
                }
                return $actions;
            })
            ->rawColumns([ 'status_badge', 'actions','nota_dinas_badge'])
            ->make(true);
        }

        return view('permohonan.index', compact('totalPermohonan', 'totalDiproses', 'totalrevisi', 'totalSelesai', 'roles'));

    }


    public function getAll(Request $request)
    {

        $currentUserId = Auth::id();
        $query = Permohonan::with('createdby', 'diteruskan');
        $roles = Role::all();

        // Filter by status if provided
        if (!empty($request->status)) {
            $query =  $query->where('status', '=', $request->status);
        }

        // Filter by tanggal if provided
        if (!empty($request->tanggal)) {
            $tanggal = $request->tanggal;
            if (strpos($tanggal, 'to') !== false) {
                // Split the range into two dates
                list($startDate, $endDate) = explode('to', $tanggal);
                $startDate = trim($startDate);
                $endDate = trim($endDate);

                // Apply the date range filter
                $query =  $query->whereBetween('tanggal_mulai_pengukuran', [$startDate, $endDate]);
            } else {
                $query =  $query->whereDate('tanggal_mulai_pengukuran', $tanggal);
            }

        }



        if (!empty($request->diteruskan_role)) {
            $query->whereHas('riwayat', function ($q) use ($request) {
                $q->where('diteruskan_ke_role', $request->diteruskan_role);
            });
        }


        if (!empty($request->diteruskan_user_name)) {
            $query->whereHas('diteruskan', function ($q) use ($request) {
                $q->where('name', 'like', "%" . $request->diteruskan_user_name . "%");
            });
        }




        if (!empty($request->perlu_diteruskan) &&  intval($request->perlu_diteruskan) > 0) {
            $query =  $query->get()->filter(function ($item) {
                return $item->perlu_diteruskan;
            });

        }

        $query = $query->orderBy('tanggal_mulai_pengukuran', 'DESC');

        // $query->orderByRaw("FIELD(status, 'draft', 'revisi','proses', 'selesai')")


        if ($request->ajax()) {
            return DataTables::of($query)
            ->addColumn('nota_dinas_badge', function ($data) {
                $status = '';
                if ($data->nota_dinas) {
                    $status = 'bg-danger';
                    return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                        . __('Nota Dinas') . '</span>';
                } else {
                    return '';
                }
            })
            ->addColumn('status_badge', function ($data) {
                $status = '';
                switch ($data->status) {
                    case 'draft' :
                        $status = 'bg-danger';
                        break;
                    case 'tolak' :
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
                return '<span class="status_badge badge p-2 px-3 rounded text-capitalize ' . $status . '">'
                    . __($data->status) . '</span>';
            })
            ->addColumn('actions', function ($data) {
                $actions = '';
                if (Auth::user()->id == $data->diteruskan_ke || (Auth::user()->id == $data->created_by && $data->status == 'draft')) {
                    $actions .= '<div class="action-btn bg-primary ms-2 btn_teruskan" data-id="'. $data->id .'" >
                                            <a  href="#" data-url="' . route('permohonan.teruskan_view', $data->id) . '"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-size="md"
                                                data-ajax-popup="true"
                                                data-bs-toggle="tooltip" title="' . __('Teruskan Penugasan') . '"
                                                data-original-title="' . __('Teruskan Penugasan') . '">
                                                <i class="ti ti-send text-white"></i>
                                            </a>
                                        </div>';
                }

                $actions .= '<div class="action-btn bg-primary ms-2">
                                            <a href="' . route('permohonan.edit', $data->id) . '"
                                                class="mx-3 btn btn-sm align-items-center"
                                                data-bs-toggle="tooltip" title="' . __('Edit') . '"
                                                data-original-title="' . __('Edit') . '">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>';



                if (auth()->user()->can('ambil permohonan') && ($data->status !== 'draft')) {
                    $actions .= '<div class="action-btn bg-info ms-2 btn-ambil-tugas" data-id="'. $data->id .'" data-url="' . route('permohonan.ambil_tugas', $data->id) . '">
                                            <a  href="#"
                                                data-original-title="' . __('Ambil Alih Tugas') . '"
                                                class="mx-3 btn btn-sm align-items-center">
                                                    <i class="ti ti-users text-white"></i>
                                            </a>
                                        </div>';
                }


                return $actions;
            })
            ->rawColumns([ 'status_badge', 'actions','nota_dinas_badge'])
            ->make(true);



        }

        return view('permohonan.all', compact('roles'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // if (!Auth::user()->can('create permohonan')) {
        //     abort(403, 'Anda tidak memiliki izin untuk mengakses sumber ini.');
        // }

        $url = route('permohonan.store');
        return view('permohonan.create', compact('url'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermohonanRequest $request)
    {

        DB::beginTransaction();
        try {
            $currentMonth = date('n');
            $currentYear = date('Y');
            $romanMonth = Utility::convertMonthToRoman($currentMonth);

            $request->merge([
                'no_berkas' =>  $request->no_berkas  . '/' . $currentYear,
                'no_surat' => $request->no_surat . '/St-22.02/' . $romanMonth . '/' . $currentYear,
                'no_surat_perintah_kerja' => $request->no_surat_perintah_kerja . '/St-22.02/' . $romanMonth . '/' . $currentYear,
                'di_305' =>  $request->di_305  . '/' . $currentYear,
                'di_302' =>  $request->di_302  . '/' . $currentYear,
                'updated_by' => auth()->user()->getId()
            ]);

            $data = Permohonan::create($request->all());

            foreach ($request->petugas_ukur as $petugas) {
                PermohonanPetugasUkur::create([
                    'permohonan_id' => $data->id,
                    'pembantu_ukur' => $petugas['pembantu_ukur'],
                    'petugas_ukur' => $petugas['petugas_ukur']
                ]);
            }

            Utility::auditTrail('create', $this->modulName, $data->id, $data->no_berkas, auth()->user());

            DB::commit();

            return $this->respond($data, ApiMessage::SUCCESFULL_CREATE);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondError(ApiMessage::FAILED_CREATE, $e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        $urlTeruskan = route('permohonan.teruskan', $id);
        $urlTolak = route('permohonan.tolak', $id);
        //allowedRoles
        $user = auth()->user();
        $userRole = $user->roles()->first()->name;
        $allowedRoles = $this->roleHierarchy[$userRole] ?? [];

        return view('permohonan.show', compact('data', 'urlTeruskan', 'urlTolak', 'allowedRoles'));
    }

    public function detail($id)
    {
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        return view('permohonan.detail', compact('data'));
    }

    public function print(Request $request, string $id)
    {
        // Fetch the data
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);

        // Generate the URL for the permohonan.detail route
        $url = route('permohonan.detail', ['id' => $id]);
        $qrCode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($url));

        $title = $request->type ." ". $data->no_berkas;

        // Determine which view to render based on the type
        if ($request->type == 'tugas pengukuran') {
            $view = 'print.tugas_pengukuran';
        } elseif ($request->type == 'lampiran tugas pengukuran') {
            $view = 'print.lampiran_tugas_pengukuran';
        } elseif ($request->type == 'perintah kerja') {
            $view = 'print.perintah_kerja';
        } else {
            $view = 'print.pemberitahuan';
        }


        //return View("$view", compact('data', 'qrCode', 'title'));
        $pdf = PDF::loadView($view, compact('data', 'qrCode', 'title'))
                    ->setPaper('a4', 'portrait');

        $title = strtoupper($request->type) . " " . $data->no_berkas;
        $title = str_replace(['/', '\\'], '-', $title);

        // Stream the PDF back to the browser or save it
        return $pdf->stream("$title.pdf");
    }




    public function printPemberitahuan(string $id)
    {
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        return view('print.pemberitahuan', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa', 'riwayat.diteruskan')->find($id);
        $user = auth()->user();
        $userRole = $user->roles()->first()->name;


        // Check if the user is a Super Admin
        if ($userRole === "Super Admin") {
            // If Super Admin, set allowed roles to all roles
            $allowedRoles = array_keys($this->roleHierarchy);
        } else {
            // Otherwise, get allowed roles based on user role
            $allowedRoles = $this->roleHierarchy[$userRole] ?? [];

        }


        $url = route('permohonan.update', $id);
        $urlTeruskan = route('permohonan.teruskan', $id);
        $urlTolak = route('permohonan.tolak', $id);
        $urlSelesai = route('permohonan.selesai', $id);
        $urlAmbilAlih = route('permohonan.ambil_tugas', $id);
        $urlPanggilDinas = route('permohonan.panggil_dinas', $id);
        $urlNotaDinas = route('permohonan.nota_dinas', $id);


        return view('permohonan.edit', compact('data', 'url', 'urlTeruskan', 'urlSelesai', 'urlTolak', 'urlAmbilAlih', 'urlPanggilDinas', 'allowedRoles', 'urlNotaDinas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermohonanRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $actions = 'update';
            $request->merge([
                'updated_by' => auth()->user()->getId()
            ]);
            $data = Permohonan::find($id);
            $data->update($request->all());


            if ($request->has('petugas_ukur') && !empty($request->petugas_ukur)) {
                PermohonanPetugasUkur::where('permohonan_id', $id)->delete();
                foreach ($request->petugas_ukur as $petugas) {
                    // Check if pembantu_ukur and petugas_ukur are not empty
                    if (!empty($petugas['pembantu_ukur']) && !empty($petugas['petugas_ukur'])) {
                        PermohonanPetugasUkur::create([
                            'permohonan_id' => $data->id,
                            'pembantu_ukur' => $petugas['pembantu_ukur'],
                            'petugas_ukur' => $petugas['petugas_ukur']
                        ]);
                    }
                }
            }


            if (!empty($request->teruskan_ke_role)) {

                $actions = 'update dan teruskan';
                $data = Permohonan::find($id);
                $data->diteruskan_ke = $request->user;
                $data->diteruskan_ke_role = $request->teruskan_ke_role;
                $data->status = 'proses';
                $data->update();

                RiwayatPermohonanDiTeruskan::create([
                    'permohonan_id' => $data->id,
                    'diteruskan_ke' => $request->user,
                    'status' => $data->status,
                    'diteruskan_ke_role' => $request->teruskan_ke_role,
                ]);

            }


            Utility::auditTrail($actions, $this->modulName, $data->id, $data->no_berkas, auth()->user());
            DB::commit();

            return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondError(ApiMessage::FAILED_UPDATE, $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = permohonan::find($id);
        if (!$data) {
            return $this->respondNotHaveAccessData();
        }
        $data->delete();
        //SAVE TO AUDIT TRAIL
        Utility::auditTrail('delete', $this->modulName, $data->id, $data->no_berkas, auth()->user());
        return $this->respond(null, ApiMessage::SUCCESFULL_DELETE);
    }


    public function teruskan(PermohonanDiteruskanRequest $request, $id)
    {

        $data = Permohonan::find($id);
        if (!$data) {
            return $this->respondNotHaveAccessData();
        }

        $data->diteruskan_ke = $request->user;
        $data->status = 'proses';
        $data->catatan_penerusan = $request->catatan_penerusan;
        $data->update();

        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'diteruskan_ke' => $request->user,
            'diteruskan_ke_role' => $request->teruskan_ke_role,
            'status' => 'peroses'
        ]);

        $userDiTeruskan = User::find($request->user);

        $description = "Permohonan dengan nomor berkas {$data->no_berkas} telah diteruskan kepada {$userDiTeruskan->name} dengan status: Diproses. Catatan: {$data->catatan_penerusan}. di teruskan oleh " .auth()->user()->name ?? '-' ;

        Utility::auditTrail('diteruskan', $this->modulName, $data->id, $data->no_berkas, auth()->user(), 'web', null, $description);

        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }


    public function tolak(Request $request, $id)
    {


        $data = Permohonan::find($id);
        if (!$data) {
            return $this->respond(null, ApiMessage::NOT_FOUND, 404);
        }

        // Retrieve all records related to the given permohonan_id, ordered by created_at in descending order
        $records = RiwayatPermohonanDiTeruskan::where('permohonan_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $userForward;
        if ($records->count() > 1) {
            // If there are multiple records, use the second latest
            $secondLatest = $records->skip(1)->first();
            $userForward = $secondLatest->diteruskan_ke;

        } else {
            // If there is only one record, use the created_by
            $userForward = $data->created_by;
        }

        if ($request->filled('di_tolak_ke')) {
            $userForward = $request->di_tolak_ke;
        }

        $data->diteruskan_ke = $userForward;
        $data->status = 'tolak';
        $data->alasan_penolakan = $request->alasan_penolakan;
        $data->update();

        // Get the user
        $user = User::find($userForward);
        // Get the user's roles
        $roleNames = $user->getRoleNames();
        // the first role name or concatenated names:
        $roleName = $roleNames->implode(', ');

        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'diteruskan_ke' => $userForward,
            'diteruskan_ke_role' => $roleName,
            'status' => 'tolak',
            'alasan_penolakan' => !empty($request->alasan_penolakan) ? $request->alasan_penolakan : null
        ]);


        $userDiKembalikan = User::find($userForward);

        $description = "Permohonan dengan nomor berkas {$data->no_berkas} telah kembalikan kepada ".$userDiKembalikan->name .
                            " alasan pengembalian/ penolakan: {$request->alasan_penolakan}. di kembalikan oleh " .auth()->user()->name  ;

        Utility::auditTrail('tolak', $this->modulName, $data->id, $data->no_berkas, auth()->user(), 'web', null, $description);

        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }

    public function selesai($id, Request $request)
    {

        $firstUserWithRole = User::role('PHP')->first();
        $data = Permohonan::find($id);
        if (!$data) {
            return $this->respond(null, ApiMessage::NOT_FOUND, 404);
        }
        $data->status = 'selesai';
        $data->catatan_selesai = $request->catatan_selesai;
        $data->diteruskan_ke = $firstUserWithRole->id ?? 0;
        $data->update();

        $user = auth()->user();
        $description = "Permohonan dengan nomor berkas {$data->no_berkas} telah diselesian oleh  {$user->name} . catatan penyelesian : {$data->catatan_selesai}" ;
        Utility::auditTrail('selesai', $this->modulName, $data->id, $data->no_berkas, auth()->user(), 'web', null, $description);

        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }


    public function panggilDinas($id, Request $request)
    {

        $data = Permohonan::find($id);

        if (!$data || !auth()->user()->can('panggil_dinas permohonan')) {
            return $this->respondNotHaveAccessData();
        }

        $panggilanDinas = RiwayatPanggilanDinas::create([
            'status' => 'selesai',
            'catatan' => $request->catatan,
            'permohonan_id' => $data->id,
            'tanggal_panggil' => $request->tanggal_panggil,
            'created_by' => auth()->user()->id,
        ]);

        $user = auth()->user();
        $description = "{$user->name} . memangil permohonan dengan no berkas $data->no_berkas, catatan : {$request->catatan}" ;
        Utility::auditTrail('panggil dinas', $this->modulName, $data->id, $data->no_berkas, auth()->user(), 'web', null, $description);

        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }



    public function printView($id)
    {
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        return view('permohonan.print_view', compact('data'));
    }
    public function pindahTugasView($id)
    {
        return view('permohonan.pindah_tugas');
    }

    public function pindahTugas($id, Request $request)
    {
        $data = Permohonan::find($id);
        $data->status = 'peroses';
        $data->diteruskan_ke = $request->dialihkan_ke;
        $data->update();

        $user = User::find($request->dialihkan_ke);
        // Get the user's roles
        $roleNames = $user->getRoleNames();
        // the first role name or concatenated names:
        $roleName = $roleNames->implode(', ');

        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'diteruskan_ke' => $user->id,
            'status' => 'peroses',
            'diteruskan_ke_role' => $roleName,
        ]);


        return $this->respond($data, "Berhasil Mengalihkan penugasan");

    }

    public function ambilTugas($id)
    {
        $data = Permohonan::find($id);

        $user = auth()->user();
        // dd(\Auth::user()->can('delete role'));
        //dd($user->getAllPermissions()->pluck('name'));
        if (!$data || !auth()->user()->can("ambil permohonan")) {
            return $this->respondNotHaveAccessData();
        }

        $data->diteruskan_ke = auth()->id();
        $data->update();
        Utility::auditTrail('ambil alih', $this->modulName, $data->id, $data->no_berkas, auth()->user());
        return $this->respond($data, "Berhasil! Anda telah berhasil mengambil alih penugasan ini");
    }

    public function teruskanView($id)
    {

        //allowedRoles
        $user = auth()->user();
        $userRole = $user->roles()->first()->name;
        $allowedRoles = $this->roleHierarchy[$userRole] ?? [];

        // Check if the user is a Super Admin
        if ($userRole === "Super Admin") {
            // If Super Admin, set allowed roles to all roles
            $allowedRoles = array_keys($this->roleHierarchy);
        } else {
            // Otherwise, get allowed roles based on user role
            $allowedRoles = $this->roleHierarchy[$userRole] ?? [];
        }

        return view('permohonan.teruskan', compact('allowedRoles'));
    }



    public function riwayatDiteruskan($id, Request $request)
    {
        $query = RiwayatPermohonanDiTeruskan::with('diteruskan')->where('permohonan_id', $id)->latest();
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
            ->rawColumns([ 'status_badge'])
            ->make(true);
        }

    }

    public function auditTrails($id, Request $request)
    {

        $query = AuditTrail::where([
                ['module_name', '=', 'Permohonan'],
                ['module_id', '=', $id]
            ])->latest();
        if ($request->ajax()) {
            return DataTables::of($query)
            ->make(true);
        }
    }


    public function notaDinas($id, Request $request)
    {
        $data = Permohonan::find($id);

        if (!$data || !auth()->user()->can('nota_dinas permohonan')) {
            return $this->respondNotHaveAccessData();
        }

        $data->nota_dinas = $request->status;
        $data->update();
        $description;


        if ($request->status) {
            $description = "$data->no_berkas di tandai sebagai nota dinas oleh ". auth()->user()->name;
            Utility::auditTrail('nota dinas', $this->modulName, $data->id, $data->no_berkas, auth()->user(), 'web', null, $description);
            return $this->respond($data, "Berhasil di tandai sebagai nota dinas.");
        } else {
            $description = "$data->no_berkas tanda nota dinas dihapus oleh ". auth()->user()->name;
            Utility::auditTrail('nota dinas', $this->modulName, $data->id, $data->no_berkas, auth()->user(), 'web', null, $description);
            return $this->respond($data, "Berhasil menghapus tanda nota dinas.");
        }

    }
}
