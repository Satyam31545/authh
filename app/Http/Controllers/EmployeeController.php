<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\Validator;


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

        return view('all_emp')->with(['my_employee' => Employee::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
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

                // Employee
                $employee = $user->employee()->create($req);

                $user->assignRole([$req['role']]);
                //    family
                if (isset($req['family']))
                    foreach ($req['family'] as $family) {
                        $employee->family()->create($family);
                    }

                // education
                if (isset($req['education']))
                    foreach ($req['education'] as $education) {
                        $employee->education()->create($education);
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
        $employee = $employee->load([
            'families',
            'education'
        ]);

        return view('view')->with(['employee' => $employee]);
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
        $val = $req->validated();
        try {
            DB::transaction(function () use ($val, $employee) {

                $employee->update($val);
                $employee->user->syncRoles([]);
                $employee->user->assignRole([$val['role']]);
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
            $employee->user->syncRoles([]);
            $employee->user->delete();
            $employee->delete();
        });


        return redirect()->back();
    }

    public function edit_s()
    {
        return view('update')->with(['employee' => Auth::user()->employee]);
    }

    public function update_s(Request $req)
    {
        $val = Validator::make($req->all(), [
            'dob' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            $employee = Auth::user()->employee;
            $employee->dob = $req['dob'];
            $employee->address = $req['address'];
            $employee->update();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
