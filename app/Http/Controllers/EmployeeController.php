<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Family;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $my_employee = Employee::all();

        $data = compact('my_employee');  
        return  view('all_emp')->with($data);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('create');   
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
          $val =  Validator::make($req->all(),[
            'name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'salary'=> 'required',
            'desigination'=> 'required',             
            'dob'=> 'required',
            'address'=> 'required'
    ])->validate();
    // validator
    
try {

        $user = new User;
        $user->email=$val['email'];
        $user->password=Hash::make($val['password']);
        $user->save();
        $users = User::where('email',$val['email'])->first();

            $employee = new Employee;
        $employee->name=$val['name'];
        $employee->user_id=$users->id;
        $employee->salary=$val['salary'];
        $employee->desigination=$val['desigination'];
        $employee->address=$val['address'];
        $employee->role=$req['role'];
        $employee->dob=$val['dob'];
        $employee->save();


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
               
        $my_employee = Employee::with("families")->with("education")->where('id',$employee->id)->first();
        $data = compact('my_employee');  
   
        return  view('view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $data = compact('employee');  
        return  view('update')->with($data);  
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
        if ($req['name']!='') { $emp->name=$req['name']; }
        if ($req['salary']!='') { $emp->salary=$req['salary']; }
        if ($req['desigination']!='') { $emp->desigination=$req['desigination']; }
        if ($req['address']!='') { $emp->address=$req['address']; }
        if ($req['role']!='') { $emp->role=$req['role']; }
        if ($req['dob']!='') { $emp->dob=$req['dob']; }
        $emp->save(); 
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
        $employee->delete();
        return "i am deleted";
    }
}
