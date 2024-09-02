<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Http\Requests\PermohonanRequest;
use App\Http\Requests\PermohonanDiteruskanRequest;
use App\Models\Utility;
use App\Models\PermohonanPetugasUkur;
use App\Models\RiwayatPermohonanDiTeruskan;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use App\ApiMessage;
use App\ApiCode;

class PenataanBatasController extends Controller
{
    protected $modulName = 'Penataan Batas';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (\Auth::user()->can('manage invoice')) {

            $query = Permohonan::query();
            $query->with('createdby');
            $query->where('jenis_permohonan', 'penataan_batas');


            // Get the currently authenticated user's ID
            $currentUserId = Auth::id();



            $query = Permohonan::with('createdby')
                ->where('jenis_permohonan', 'penataan_batas')
                ->where(function ($q) use ($currentUserId) {
                    $q->where('diteruskan_ke', 'like', "%{$currentUserId}%")
                      ->orWhere('created_by', $currentUserId) // Allow creator to see the data
                      ->orWhereHas('petugasUkur', function ($q) use ($currentUserId) {
                          $q->where('user_id', $currentUserId);
                      });
                });




            if (!empty($request->status)) {
                $query->where('status', '=', (int) $request->status);
            }

            if ($request->ajax()) {
                return DataTables::of($query)


                ->addColumn('status_badge', function ($data) {
                    $status = $data->is_active > 0 ? 'bg-danger' : 'bg-success';
                    return '<span class="status_badge badge p-2 px-3 rounded ' . $status . '">'
                        . __($data->status) . '</span>';
                })
                ->addColumn('actions', function ($data) {
                    $actions = '';

                    // Show Invoice
                    if (Gate::check('show invoice')) {
                        $actions .= '<div class="action-btn bg-info ms-2">
                                        <a href="' . route('penataan_batas.show', [Crypt::encrypt($data->id)]) . '"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-bs-toggle="tooltip" title="' . __('Show') . '"
                                            data-original-title="' . __('Detail') . '">
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                    </div>';
                    }

                    // Edit Invoice
                    if (Gate::check('edit invoice')) {
                        $actions .= '<div class="action-btn bg-primary ms-2">
                                        <a href="' . route('penataan_batas.edit', [Crypt::encrypt($data->id)]) . '"
                                            class="mx-3 btn btn-sm align-items-center"
                                            data-bs-toggle="tooltip" title="' . __('Edit') . '"
                                            data-original-title="' . __('Edit') . '">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                    </div>';
                    }

                    // Delete Invoice
                    if (Auth::user()->can('delete invoice')) {
                        $actions .= '<div class="action-btn bg-danger ms-2">
                                        <form method="POST" action="' . route('penataan_batas.destroy', $data->id) . '" id="delete-form-' . $data->id . '">
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

            return view('penataan_batas.index');
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $url = route('penataan_batas.store');
        return view('penataan_batas.create', compact('url'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermohonanRequest $request)
    {

        $request->merge(['jenis_permohonan' => 'penataan_batas',
            'diteruskan_ke' => $request->petugas_ukur[0]
        ]);

        $data = Permohonan::create($request->all());

        foreach ($request->petugas_ukur as $dataId) {
            PermohonanPetugasUkur::create([
                'permohonan_id' => $data->id,
                'user_id' => $dataId,
            ]);
        }

        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'user_id' => $dataId,
        ]);


        //Utility::auditTrail('create', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond($data);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $Id = \Crypt::decrypt($id);
        $data = Permohonan::with('petugasUkur.user', 'createdby', 'kecamatan', 'desa')->find($Id);
        $urlTeruskan = route('penataan_batas.teruskan', $Id);
        return view('penataan_batas.show', compact('data', 'urlTeruskan'));
    }


    public function print(string $id)
    {

        $Id = \Crypt::decrypt($id);
        $data = Permohonan::with('petugasUkur.user', 'createdby', 'kecamatan', 'desa')->find($Id);
        return view('penataan_batas.print', compact('data'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $Id = \Crypt::decrypt($id);
        $data = Permohonan::with('petugasUkur.user')->find($Id);
        $url = route('penataan_batas.update', $Id);
        return view('penataan_batas.edit', compact('data', 'url', ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermohonanRequest $request, $id)
    {
        $request->merge([
            'updated_by' => auth()->user()->getId(),
            'diteruskan_ke' => $request->petugas_ukur[0]
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


        RiwayatPermohonanDiTeruskan::create([
                'permohonan_id' => $data->id,
                'user_id' =>  $request->petugas_ukur[0]
            ]);


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
        $data->update();


        RiwayatPermohonanDiTeruskan::create([
            'permohonan_id' => $data->id,
            'user_id' => $request->user,
            'diteruskan_ke' => $request->options_select,
        ]);


        Utility::auditTrail('diteruskan', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond($data, ApiMessage::SUCCESFULL_UPDATE);
    }

}