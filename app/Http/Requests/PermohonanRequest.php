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


        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();

        // if ($user->hasRole('Petugas Jadwal')) {

        //     $currentTime = now()->setTimezone('Asia/Makassar');
        //     $allowedRanges = [
        //         ['start' => '09:00', 'end' => '10:00'],
        //         ['start' => '11:00', 'end' => '12:00'],
        //         ['start' => '13:00', 'end' => '14:00'],
        //     ];
        //     $isAllowed = false;

        //     foreach ($allowedRanges as $range) {
        //         $startHour = (int) substr($range['start'], 0, 2); // Konversi ke integer
        //         $startMinute = (int) substr($range['start'], 3, 2); // Konversi ke integer
        //         $endHour = (int) substr($range['end'], 0, 2); // Konversi ke integer
        //         $endMinute = (int) substr($range['end'], 3, 2); // Konversi ke integer

        //         $start = now()->setTimezone('Asia/Makassar')->startOfDay()->addHours($startHour)->addMinutes($startMinute);
        //         $end = now()->setTimezone('Asia/Makassar')->startOfDay()->addHours($endHour)->addMinutes($endMinute);

        //         if ($currentTime->between($start, $end)) {
        //             $isAllowed = true;
        //             break;
        //         }
        //     }

        //     if (!$isAllowed) {
        //         throw new \Exception('Akses hanya diizinkan pada rentang waktu  09:00-10:00, 11:00-12:00, atau 13:00-14:00 WITA.');
        //     }


        // }




        return true;

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
            'no_berkas' => 'required|unique:permohonan,no_berkas,except,id',
            'jenis_kegiatan' => 'required|in:Penggabungan Bidang,Pemecahan Bidang,Pengukuran Dan Pemetaan Kadastral,Pemisahan Bidang,Penataan Batas,Pengukuran Ulang Dan Pemetaan Kadastral,Permohonan SK Konfirmasi,Permohonan SK Pemberian Hak Guna Bangunan Badan Hukum,Permohonan SK Pemberian Hak Milik Perorangan,Permohonan SK Pemberian Hak Pakai Badan Hukum,Permohonan SK Pemberian Hak Pakai Instansi/Badan Usaha Pemerintah,Permohonan SK Pemberian HGB/HP di atas HPL,Waris dan Pemecahan,Permohonan SK Pemberian Hak Dengan Konstatasi,Pendaftaran Tanah Pertama Kali Pemberian Hak,Pengukuran Pendaftaran Tanah Pertama Kali /Konversi/Pemberian dan Penegasan Hak',
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


        if (in_array("PUT", $this->route()->methods())) {
            $rules['no_berkas'] = ['required'];
        }


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


    public function messages(): array
    {
        return [
            'authorized' => 'Akses hanya diizinkan pada rentang waktu 09:00-10:00, 11:00-12:00, atau 13:00-14:00 WITA.',
        ];
    }
}
