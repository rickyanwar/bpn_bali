<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PermohonanRequest;
use App\Models\Utility;
use App\Models\PermohonanPetugasUkur;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonanDiTeruskan;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Auth;

class PenggabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filterable = ['keyword'];
        $filterableValues = array_filter($request->only($filterable));
        $data = Permohonan::query();
        $data = $data->when(count($filterableValues), function ($query) use ($filterableValues) {
            foreach ($filterableValues as $column => $value) {
                if ($column == 'keyword') {
                    $query->where('no_surat', 'like', '%' . $value . '%')
                    ->orWhere('nama_pemohon', 'like', '%' . $value . '%');
                }
                // $query->where($column, 'like', '%' . $value . '%');
            }
        });

        $data = $data->latest()->paginate(50);

        return $this->respond($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermohonanRequest $request)
    {

        $request->merge(['jenis_permohonan' => 'penggabungan',
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

        $data = Permohonan::with('petugasUkur.user', 'createdby', 'kecamatan', 'desa')->find($id);
        return $this->respond($data);

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
                'user_id' => $dataId,
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
}
