<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Education;
use App\Models\Employee;
use App\Models\IdCode;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('all_emp')->with(['employees' => Employee::simplePaginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_code = IdCode::where("table_name", "employees")->first();
        return view('create')->with(['id_code' => $id_code->code_char . $id_code->code_num]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $req)
    {
        $req = $req->validated();
        try {
            DB::transaction(function () use ($req) {
// user
                $req['password'] = Hash::make($req['password']);
                $user = User::create($req);
                $req['user_id'] = $user->id;
                // Employee
                // id code
                Id_code('employees', $req['employee_id']);

                // id code

                $employee = $user->employee()->create($req);
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
            return $e->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('view')->with(['user' => $employee->user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('update')->with(['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $req, Employee $employee)
    {
        $validated = $req->validated();
        try {
            DB::transaction(function () use ($validated, $employee) {

                $employee->update($validated);
                DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
                $user = User::find($employee->user_id);
                $user->assignRole([$validated['role']]);
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
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

        return redirect()->back();
    }

    public function edit_s()
    {
        return view('update')->with(['employee' => Auth::user()->employee]);
    }

    public function update_s(request $req)
    {
        $validated = Validator::make($req->all(), [
            'dob' => 'required',
            'address' => 'required',
        ])->validate();
        try {
            Auth::user()->employee()->update($validated);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
