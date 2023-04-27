<?php

namespace App\Http\Controllers;

use App\Models\IdCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdCodeController extends Controller
{

    public function index(): View
    {
        return view('id_code.id_code')->with(['id_codes' => IdCode::all()]);
    }

    public function update(request $req, IdCode $idCode)
    {
        try {
            DB::transaction(function () use ($req, $idCode) {
                $idCode->update(["code_char" => $req['id_code']]);
            });

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }
}
