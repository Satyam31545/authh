<?php

namespace App\Http\Controllers\Api;
use App\Models\Education;
use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EducationApiController extends Controller
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
            'edu_level' => 'required',
            'course_n' => 'required',
            'place' => 'required',
            'percent' => 'required',

        ]);
        if ($val->fails()) {
              return response()->json($val->errors(), 200);
        }
        Education::create($val->validated());
        return response()->json(['message' => "Education created successfuly"], 200);

    }
}
