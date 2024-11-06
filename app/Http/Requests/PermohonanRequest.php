<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use DB;

class PermohonanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {


        $method          = $this->route()->methods();

        $request = $this->request->all();
        $rules = [
            'di_305' => 'required',
            'di_302' => 'required',
            'tanggal_mulai_pengukuran' => 'date|required',
            // 'tanggal_berakhir_pengukuran' => 'date|required',
            'no_surat_perintah_kerja' => 'nullable',
            'no_berkas' => 'required',
            'jenis_kegiatan' => 'required|in:Penggabungan Bidang,Pemecahan Bidang,Pengukuran Dan Pemetaan Kadastral,Pemisahan Bidang,Penataan Batas,Pengukuran Ulang Dan Pemetaan Kadastral,Permohonan SK Konfirmasi,Permohonan SK Pemberian Hak Guna Bangunan Badan Hukum,Permohonan SK Pemberian Hak Milik Perorangan,Permohonan SK Pemberian Hak Pakai Badan Hukum,Permohonan SK Pemberian Hak Pakai Instansi/Badan Usaha Pemerintah,Permohonan SK Pemberian HGB/HP di atas HPL,Waris dan Pemecahan',
            'nama_pemohon' => 'required',
            'kecamatan' => [
                'required',
                function ($attr, $value, $fail) use ($request) {
                    $kecamatan = \App\Models\WilayahIndonesia::where(DB::raw('LENGTH(kode)'), '=', '8')
                        ->where('nama', $this->request->get('kecamatan'))->first();
                    if (!$kecamatan) {
                        $fail($attr . ' tidak valid.');
                    }
                }
            ],
            'desa' => [
                'required',
                function ($attr, $value, $fail) use ($request) {
                    $desa = \App\Models\WilayahIndonesia::where(DB::raw('LENGTH(kode)'), '=', '13')
                        ->where('nama', $this->request->get('desa'))->first();
                    if (!$desa) {
                        $fail($attr . ' tidak valid.');
                    }
                }
            ],
            'luas' => 'required|numeric',
                'petugas_ukur' => [
                    'required',
                    'array',
                    'min:1'
            ],
            'petugas_ukur' => [
                        'required',
                        'array',
                        'min:1'
                ],
            'petugas_ukur.*.petugas_ukur' => [
                    'required',
                    'exists:users,id'
                ],
            'petugas_ukur.*.pembantu_ukur' => [
                    'required',
            ],
        ];


        // if (in_array("PUT", $this->route()->methods())) {

        //     $rules['petugas_ukur'] = [
        //                               'nullable',
        //                           'array',
        //     ];

        //     $rules['petugas_ukur.*.petugas_ukur'] = [
        //                     'sometimes',
        //                     'required',
        //                     'exists:users,id'
        //                 ];
        //     $rules['petugas_ukur.*.pembantu_ukur'] = [
        //         'nullable',
        //         'required_if:petugas_ukur.*.petugas_ukur,!=,null',
        //     ];
        // }

        return $rules;
    }

}
