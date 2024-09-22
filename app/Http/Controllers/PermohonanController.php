<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Http\Requests\PermohonanRequest;
use App\Http\Requests\PermohonanDiteruskanRequest;
use App\Models\Utility;
use App\Models\User;
use App\Models\Documents;
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

// use Barryvdh\DomPDF\Facade as PDF;

class PermohonanController extends Controller
{
    protected $modulName = 'Pengukuran';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (\Auth::user()->can('show permohonan')) {
            // Get the logged-in user
            $user = Auth::user();
            // Query the total number of permohonan (requests) for this user
            $totalPermohonan = Permohonan::where('diteruskan_ke', $user->id)->count();
            // Query the number of 'Diproses' status requests for this user
            $totalDiproses = Permohonan::where('diteruskan_ke', $user->id)
                ->where('status', 'proses')
                ->count();

            // Query the number of 'revisi' status requests for this user
            $totalrevisi = Permohonan::where('diteruskan_ke', $user->id)
                ->where('status', 'revisi')
                ->count();

            // Query the number of 'Selesai' status requests for this user
            $totalSelesai = Permohonan::where('diteruskan_ke', $user->id)
                ->where('status', 'selesai')
                ->count();

            $query = Permohonan::query();
            $query->with('createdby');
            // Get the currently authenticated user's ID
            $currentUserId = Auth::id();

            // if (!empty($request->date)) {
            //     dd($request->date);
            // }


            $query = Permohonan::with('createdby', 'diteruskan')
                // ->where('jenis_permohonan', 'permohonan')
                ->where(function ($q) use ($currentUserId) {
                    $q->where('diteruskan_ke', 'like', "%{$currentUserId}%")
                     ->orWhere('created_by', $currentUserId)
                      ->orWhereHas('petugasUkur', function ($q) use ($currentUserId) {
                          $q->where('petugas_ukur', $currentUserId);
                      });
                });



            if (!empty($request->status)) {
                $query->where('status', '=', (int) $request->status);
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
                ->addColumn('actions', function ($data) {
                    $actions = '';

                    // Show Invoice
                    if (Gate::check('show permohonan')) {
                        $actions .= '<div class="action-btn bg-info ms-2">
                                        <a href="' . route('permohonan.show', ($data->id)) . '"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-bs-toggle="tooltip" title="' . __('Show') . '"
                                            data-original-title="' . __('Detail') . '">
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                    </div>';
                    }

                    // Edit Invoice
                    if (Gate::check('show permohonan') && $data->status == 'draft') {
                        $actions .= '<div class="action-btn bg-primary ms-2">
                                        <a href="' . route('permohonan.edit', $data->id) . '"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-bs-toggle="tooltip" title="' . __('Edit') . '"
                                            data-original-title="' . __('Edit') . '">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>';
                    }



                    if (Gate::check('show permohonan')) {
                        $actions .= '<div class="action-btn bg-primary ms-2 dialihkan_ke" data-id="'. $data->id .'" >
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

                    // Delete Invoice
                    if (Auth::user()->can('show permohonan') && $data->status == 'draft') {
                        $actions .= '<div class="action-btn bg-danger ms-2">
                                        <form method="POST" action="' . route('permohonan.destroy', $data->id) . '" id="delete-form-' . $data->id . '">
                                            ' . csrf_field() . '
                                            ' . method_field('DELETE') . '
                                            <a href="#"
                                                class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                data-bs-toggle="tooltip"
                                                title="' . __('Delete') . '"
                                                data-original-title="' . __('Delete') . '"
                                                data-confirm="' . __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') . '"
                                                data-confirm-yes="document.getElementById(\'delete-form-' . $data->id . '\').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                        </form>
                                    </div>';
                    }

                    return $actions;
                })
                ->rawColumns([ 'status_badge', 'actions'])
                ->make(true);



            }

            return view('permohonan.index', compact('totalPermohonan', 'totalDiproses', 'totalrevisi', 'totalSelesai'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $url = route('permohonan.store');
        return view('permohonan.create', compact('url'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermohonanRequest $request)
    {


        $data = Permohonan::create($request->all());

        foreach ($request->petugas_ukur as $petugas) {
            PermohonanPetugasUkur::create([
                'permohonan_id' => $data->id,
                'pendamping' => $petugas['pendamping'],
                'petugas_ukur' => $petugas['petugas_ukur']
            ]);
        }

        // RiwayatPermohonanDiTeruskan::create([
        //     'permohonan_id' => $data->id,
        //     'user_id' => $dataId,
        // ]);


        //Utility::auditTrail('create', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond($data);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        $urlTeruskan = route('permohonan.teruskan', $id);
        $urlTolak = route('permohonan.tolak', $id);
        $dokument = Documents::get();
        $roles = Role::get();

        // Define the role hierarchy
        $roleHierarchy = [
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
            "Admin" => [
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
                "Admin"
            ],
            "Kepala Seksi" => [
                "Koordinator Wilayah",
                "Koordinator Pengukuran",
                "Admin"
            ]
        ];

        $user = auth()->user();
        $userRole = $user->roles()->first()->name;
        $allowedRoles = $roleHierarchy[$userRole] ?? [];

        return view('permohonan.show', compact('data', 'urlTeruskan', 'urlTolak', 'dokument', 'allowedRoles'));
    }



    public function print(Request $request, string $id)
    {

        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);

        // Generate the URL for the permohonan.show route
        $url = route('permohonan.show', ['permohonan' => $id]);
        $qrCode = QrCode::size(80)->generate($url);


        if ($request->type == 'tugas pengukuran') {
            return view('print.tugas_pengukuran', compact('data', 'qrCode'));
        } elseif ($request->type == 'lampiran tugas pengukuran') {
            return view('print.lampiran_tugas_pengukuran', compact('data', 'qrCode'));
        } elseif ($request->type == 'perintah kerja') {
            return view('print.perintah_kerja', compact('data', 'qrCode'));
        } elseif ($request->type == 'pemberitahuan') {
            return view('print.pemberitahuan', compact('data', 'qrCode'));
        }

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
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        $url = route('permohonan.update', $id);
        return view('permohonan.edit', compact('data', 'url', ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermohonanRequest $request, $id)
    {
        $request->merge([
            'updated_by' => auth()->user()->getId(),
            // 'diteruskan_ke' => $request->petugas_ukur[0]
        ]);


        $data = Permohonan::find($id);
        $data->update($request->all());
        PermohonanPetugasUkur::where('permohonan_id', $id)->delete();

        foreach ($request->petugas_ukur as $dataId) {
            PermohonanPetugasUkur::create([
                'permohonan_id' => $data->id,
                'user_id' => $dataId,
            ]);
        }


        Utility::auditTrail('update', $this->modulName, $data->id, $data->no_surat, auth()->user());

        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $data = KartuKeluarga::find($id);
        //CHECK IF DATA EXIST AND USER CAN ACCESS DATA
        // if(!$data || !auth()->user()->can('kartu-keluarga_list_all') && $data->created_by !=  auth()->user()->getId()) {
        //     return $this->respondNotHaveAccessData();
        // }

        // if($data->status !== 'permohonan') {
        //     return $this->respondWithError(ApiCode::NOT_ACCEPTABLE, ApiMessage::CAN_T_DELETE);
        // }

        $data->delete();
        //SAVE TO AUDIT TRAIL
        Helper::auditTrail('delete', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond(null, ApiMessage::SUCCESFULL_DELETE);

    }


    public function teruskan(PermohonanDiteruskanRequest $request, $id)
    {

        $data = Permohonan::find($id);
        $data->diteruskan_ke = $request->user;
        $data->dokumen_terlampir = json_encode($request->dokumen_terlampir);
        $data->status = 'proses';
        $data->update();

        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'diteruskan_ke' => $request->user,
            'diteruskan_ke_role' => $request->diteruskan_ke_role,
            'dokumen_terlampir' => json_encode($request->dokumen_terlampir),
            'status' => 'peroses'
        ]);


        Utility::auditTrail('diteruskan', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }


    public function tolak(Request $request, $id)
    {

        // Retrieve all records related to the given permohonan_id, ordered by created_at in descending order
        $records = RiwayatPermohonanDiTeruskan::where('permohonan_id', $id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        if ($records->count() > 1) {
            // If there are multiple records, use the second latest
            $secondLatest = $records->skip(1)->first();
        } else {
            // If there is only one record, use the latest (or only) one
            $secondLatest = $records->first();
        }

        $data = Permohonan::find($id);
        $data->diteruskan_ke = $secondLatest->user_id;
        $data->status = 'revisi';
        $data->alasan_penolakan = $request->alasan_penolakan;
        $data->dokumen_terlampir = $secondLatest->dokumen_terlampir;
        $data->update();

        // Get the user
        $user = User::find($secondLatest->user_id);
        // Get the user's roles
        $roleNames = $user->getRoleNames();
        // the first role name or concatenated names:
        $roleName = $roleNames->implode(', ');

        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'diteruskan_ke' => $secondLatest->user_id,
            'diteruskan_ke_role' => $roleName,
            'alasan_penolakan' => !empty($request->alasan_penolakan) ? $request->alasan_penolakan : null
        ]);


        Utility::auditTrail('revisi', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
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
            'diteruskan_ke_role' => $roleName,
        ]);


        return $this->respond($data, "Berhasil Mengalihkan penugasan");

    }
}
