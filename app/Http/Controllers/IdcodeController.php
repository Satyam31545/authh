<?php

namespace App\Http\Controllers;

use App\Models\IdCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdcodeController extends Controller
{

    public function index()
    {
        return view('id_code.id_code')->with(['id_codes' => IdCode::all()]);
    }

    public function update(request $req, IdCode $idcode)
    {
        DB::transaction(function () use ($req, $idcode) {
            $idcode->update(["code_char" => $req['id_code']]);
        });

        return redirect()->back();

    }
}
