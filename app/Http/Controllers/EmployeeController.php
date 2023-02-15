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
        $val = Validator::make($req['employee'][0], [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'salary' => 'required',
            'desigination' => 'required',
            'dob' => 'required',
            'address' => 'required',
        ])->validate();
        // validator

        try {
            DB::transaction(function () use ($req) {

                $user = User::create([
                    'email' => $req['employee'][0]['email'],
                    'password' => Hash::make($req['employee'][0]['password']),
                ]);

                $myemployee = Employee::create([
                    'name' => $req['employee'][0]['name'],
                    'user_id' => $user->id,
                    'salary' => $req['employee'][0]['salary'],
                    'desigination' => $req['employee'][0]['desigination'],
                    'address' => $req['employee'][0]['address'],
                    'dob' => $req['employee'][0]['dob'],

                ]);

                if ($req['name1']) {
                    for ($i = 1; $i < $req['add']; $i++) {
                        $Emp_fam = new Family;
                        $Emp_fam->employee_id = $myemployee->id;
                        $Emp_fam->name = $req['name' . $i];
                        $Emp_fam->age = $req['age' . $i];
                        $Emp_fam->relation = $req['relation' . $i];
                        $Emp_fam->employeed = $req['employed' . $i];
                        $Emp_fam->save();
                    }
                }

                if ($req['edu_level1']) {
                    for ($i = 1; $i < $req['add1']; $i++) {

                        $Emp_fam = new Education;
                        $Emp_fam->employee_id = $myemployee->id;
                        $Emp_fam->edu_level = $req['edu_level' . $i];
                        $Emp_fam->course_n = $req['course_n' . $i];
                        $Emp_fam->place = $req['place' . $i];
                        $Emp_fam->percent = $req['percent' . $i];
                        $Emp_fam->save();
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

        $my_employee = Employee::with("families")->with("education")->where('id', $employee->id)->first();
        $role = User::find($my_employee->user_id)->getRoleNames()[0];
        $data = compact('my_employee', 'role');

        return view('view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $role = User::find($employee->user_id)->getRoleNames()[0];

        $data = compact('employee', 'role');
        return view('update')->with($data);
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
        try {
            $emp = $employee;
            if ($req['name'] != '') {$emp->name = $req['name'];}
            if ($req['salary'] != '') {$emp->salary = $req['salary'];}
            if ($req['desigination'] != '') {$emp->desigination = $req['desigination'];}
            if ($req['address'] != '') {$emp->address = $req['address'];}
            if ($req['dob'] != '') {$emp->dob = $req['dob'];}
            $emp->save();

            DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
            $user = User::find($employee->user_id);
            $user->assignRole([$req->role]);
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
        $employee->families()->delete();
        $employee->education()->delete();
        DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
        $employee->delete();

        return redirect()->back();
    }
}
