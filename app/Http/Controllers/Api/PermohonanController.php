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
use App\ApiMessage;
use App\ApiCode;

class PermohonanController extends Controller
{
    protected $modulName = 'Permohonan';
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


        $data = Permohonan::create($request->all());
        foreach ($request->petugas_ukur as $petugas) {
            PermohonanPetugasUkur::create([
                'permohonan_id' => $data->id,
                'pendamping' => $petugas['pendamping'],
                'petugas_ukur' => $petugas['petugas_ukur']
            ]);
        }

        Utility::auditTrail('create', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond($data);


    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Permohonan::with('petugasUkur.petugas', 'petugasUkur.petugas_pendamping', 'createdby', 'kecamatan', 'desa')->find($id);
        return $this->respond($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermohonanRequest $request, $id)
    {
        $request->merge([
                  'updated_by' => auth()->user()->getId()
        ]);

        $data = Permohonan::find($id);
        $data->update($request->all());
        PermohonanPetugasUkur::where('permohonan_id', $id)->delete();

        foreach ($request->petugas_ukur as $petugas) {
            PermohonanPetugasUkur::create([
                'permohonan_id' => $data->id,
                'pendamping' => $petugas['pendamping'],
                'petugas_ukur' => $petugas['petugas_ukur']
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

        $data = Permohonan::find($id);
        $data->delete();
        //SAVE TO AUDIT TRAIL
        Utility::auditTrail('delete', $this->modulName, $data->id, $data->no_surat, auth()->user());
        return $this->respond(null, ApiMessage::SUCCESFULL_DELETE);

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
