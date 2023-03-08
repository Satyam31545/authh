<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Employee;
use App\Models\Family;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Support\Facades\Auth;


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
        $my_employee = Employee::all();

        $data = compact('my_employee');
        return view('all_emp')->with($data);
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
    public function store(Request $req)
    {

        // validator
        $val = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
            'salary' => 'required',
            'desigination' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'family' => 'required|array',
            'education' => 'required|array',
            'family.*.name' => 'nullable',
            'family.*.age' => 'nullable',
            'family.*.relation' => 'nullable',
            'family.*.employeed' => 'nullable',
            'education.*.edu_level' => 'nullable',
            'education.*.course_n' => 'nullable',
            'education.*.place' => 'nullable',
            'education.*.percent' => 'nullable',
        ])->validate();
        // // validator
$req =$val;
        try {
            DB::transaction(function () use ($req) {
// user
$req['password']=Hash::make($req['password']);
                $user = User::create($req);
                // Employee  
$req['user_id']=$user->id;
                $myemployee = Employee::create($req);

                $user->assignRole([$req['role']]);
            //    family
                    foreach ($req['family'] as $family) {
                         if ($family['name'] && $family['age']){
                        $family['employee_id']=$myemployee->id;
                        $myfamily = Family::create($family);
                    }
                }

                // education
                    foreach ($req['education'] as $education) {
                if ($education['course_n']) {
                    $education['employee_id']=$myemployee->id;
                    $myeducation = Education::create($education);
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
        return view('view')->with(['user'=>$employee->users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('update')->with(['employee'=>$employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Employee $employee)
    {
        $val = Validator::make($req->all(), [
            'name' => 'required',
            'role' => 'required',
            'salary' => 'required',
            'desigination' => 'required',
            'dob' => 'required',
            'address' => 'required',
        ])->validate();
        try {
        DB::transaction(function () use ($val,$employee) {

            $employee->update($val);
            DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
            $user = User::find($employee->user_id);
            $user->assignRole([$val['role']]);
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
        $employee->users->delete();
        $employee->delete();
        });
        

        return redirect()->back();
    }

    public function edit_s()
    {
        return view('update')->with(['employee'=>Auth::user()->employees]);
    }

    public function update_s(request $req)
    {
        $val = Validator::make($req->all(), [
            'dob' => 'required',
            'address' => 'required',
        ])->validate();
        try {
            $id = Auth::user()->id;
            $emp = employee::find($id);
            $emp->dob = $req['dob'];
            $emp->address = $req['address'];
            $emp->update();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
