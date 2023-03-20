<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Education;
use App\Models\Employee;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeApiController extends Controller
{
    /**
     * Bearer 3|wmdIeZLruG8DPqqeDvtHkVVboep0X5HPa1K8okbm
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['employees' => Employee::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $req = $request->validated();

        try {
            DB::transaction(function () use ($req) {
                // user
                $req['password'] = Hash::make($req['password']);
                $user = User::create($req);
                // Employee
                $req['user_id'] = $user->id;
                $employee = Employee::create($req);

                $user->assignRole([$req['role']]);

                //    family
                if (isset($req['family'])) {
                    foreach ($req['family'] as $family) {
                        $employee->families()->create($family);
                    }
                }
                // education
                if (isset($req['education'])) {
                    foreach ($req['education'] as $education) {
                        $employee->education()->create($education);
                    }
                }

            });

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);

        }
        return response()->json(['message' => "employee created successfuly"], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json(['user' => $employee->user, 'Employee' => $employee], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {

        $val = $request->validated();
        try {
            DB::transaction(function () use ($val, $employee) {

                $employee->update($val);
                DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
                $user = User::find($employee->user_id);
                $user->assignRole([$val['role']]);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);

        }
        return response()->json(['message' => "employee updated successfully"], 202);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {

        DB::transaction(function () use ($employee) {
            $employee->families()->delete();
            $employee->education()->delete();
            DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
            $employee->user->delete();
            $employee->delete();
        });
        return response()->json(['message' => "employee deleted successfully"], 200);

    }
}