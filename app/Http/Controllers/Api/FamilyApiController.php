<?php

namespace App\Http\Controllers\Api;
use App\Models\Family;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FamilyApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'employee_id' => 'required',
            'name' => 'required',
            'age' => 'required',
            'relation' => 'required',
            'employeed' => 'required',

        ]);
        if ($val->fails()) {
              return response()->json($val->errors(), 200);
        }
        Family::create($val->validated());
        return response()->json(['message' => "Family created successfuly"], 200);

    }


}
