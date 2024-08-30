<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WilayahIndonesia;
use DB;

class WilayahIndonesiaController extends Controller
{
    public function provinsi(Request $request)
    {
        $filterable = ['keyword'];
        $filterableValues = array_filter($request->only($filterable));
        $wi = WilayahIndonesia::query();
        $data = $wi->where(DB::raw('LENGTH(kode)'), '=', '2')->
            when(count($filterableValues), function ($query) use ($filterableValues) {
                foreach ($filterableValues as $coulmn => $value) {
                    if ($coulmn == 'keyword') {
                        $query->where('nama', 'like', '%' . $value . '%');
                    }
                }
            })->orderBy('nama', 'ASC')->get();

        return $this->respond($data);
    }

    public function kabupatenKota(Request $request)
    {
        $filterable = ['keyword', 'provinsi'];
        $filterableValues = array_filter($request->only($filterable));
        $wi = WilayahIndonesia::query();
        $data = $wi->where(DB::raw('LENGTH(kode)'), '=', '5')->
            when(count($filterableValues), function ($query) use ($filterableValues) {
                foreach ($filterableValues as $coulmn => $value) {


                    if ($coulmn == 'keyword') {
                        $query->where('nama', 'like', '%' . $value . '%');
                    }
                    if ($coulmn == 'provinsi') {
                        $query->where('kode', 'like', $value . '%')->orWhere('nama', 'like', '%' . $value . '%');
                    }

                }
            })->orderBy('nama', 'ASC')->get();

        return $this->respond($data);
    }

    public function kecamatan(Request $request)
    {
        $filterable = ['keyword', 'kabupaten'];
        $filterableValues = array_filter($request->only($filterable));
        $wi = WilayahIndonesia::query();
        $data = $wi->where(DB::raw('LENGTH(kode)'), '=', '8')->
            when(count($filterableValues), function ($query) use ($filterableValues) {
                foreach ($filterableValues as $coulmn => $value) {

                    if ($coulmn == 'keyword') {
                        $query->where('nama', 'like', '%' . $value . '%');
                    }
                    if ($coulmn == 'kabupaten') {
                        $query->where('kode', 'like', $value . '%')->orWhere('nama', 'like', '%' . $value . '%');
                    }

                }
            })->orderBy('nama', 'ASC')->get();

        return $this->respond($data);
    }

    public function kelurahanDesa(Request $request)
    {
        $filterable = ['keyword', 'kecamatan'];
        $filterableValues = array_filter($request->only($filterable));
        $wi = WilayahIndonesia::query();
        $data = $wi->where(DB::raw('LENGTH(kode)'), '=', '13')->
            when(count($filterableValues), function ($query) use ($filterableValues) {
                foreach ($filterableValues as $coulmn => $value) {
                    if ($coulmn == 'keyword') {
                        $query->where('nama', 'like', '%' . $value . '%');
                    }
                    if ($coulmn == 'kecamatan') {
                        $query->where('kode', 'like', $value . '%')->orWhere('nama', 'like', '%' . $value . '%');
                    }

                }
            })->orderBy('nama', 'ASC')->get();
        return $this->respond($data);
    }
}
