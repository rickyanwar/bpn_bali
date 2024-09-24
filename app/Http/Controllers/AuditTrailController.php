<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\AuditTrail;

class AuditTrailController extends Controller
{
    public function index(Request $request)
    {


        $query = AuditTrail::with('createdBy');
        if ($request->ajax()) {
            return DataTables::of($query)
            ->make(true);
        }

        return view('audit.index');

    }
}
