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

        $request = $this->request->all();
        $rules = [
                    'di_305' => 'required',
                    'di_302' => 'required',
                    'tanggal_mulai_pengukuran' => 'date|required',
                    'tanggal_berakhir_pengukuran' => 'date|required',
                    'surat_perintah_kerja' => 'nullable',
                    'jenis_kegiatan' => 'required|in:Penggabungan,Pemecahan,Pengukuran,Penataan Batas,Pengembalian Batas,Permohonan SK,Konversi',
                    'nama_pemohon' => 'required',
                    'kecamatan' => [ 'required', function ($attr, $value, $fail) use ($request) {
                        $kecamatan = \App\Models\WilayahIndonesia::where(DB::raw('LENGTH(kode)'), '=', '8')
                            ->where('nama', $this->request->get('kecamatan'))->first();
                        if (!$kecamatan) {
                            $fail($attr . ' tidak valid.');
                        }

                    }],
                    'desa' => [ 'required', function ($attr, $value, $fail) use ($request) {
                        $desa = \App\Models\WilayahIndonesia::where(DB::raw('LENGTH(kode)'), '=', '13')
                            ->where('nama', $this->request->get('desa'))->first();
                        if (!$desa) {
                            $fail($attr . ' tidak valid.');
                        }
                    }],
                    'luas' => 'required|numeric',
                    'petugas_ukur' => [
                                'required',
                                'array',
                                'min:1'
                        ],
                    'petugas_ukur.*.petugas_ukur' => [
                            'required',
                            'exists:users,id'  // Validate that the petugas_ukur exists in users table
                        ],
                    'petugas_ukur.*.pembantu_ukur' => [
                            'required',

                     ],
                ]
        ;


        return $rules;

    }
}
