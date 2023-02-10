<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Family;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use DB;
class EmployeeController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
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
        $employee->dob=$val['dob'];
        $employee->save();
        $user->assignRole($req['role']);

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
        $role=  User::find($my_employee->user_id)->getRoleNames()[0];
        $data = compact('my_employee','role');  
   
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
       $role=  User::find($employee->user_id)->getRoleNames()[0];
   
        $data = compact('employee','role');  
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
        if ($req['dob']!='') { $emp->dob=$req['dob']; }
        $emp->save(); 

        DB::table('model_has_roles')->where('model_id',$employee->user_id)->delete();
        $user=  User::find($employee->user_id);
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
        DB::table('model_has_roles')->where('model_id',$employee->user_id)->delete();

        $employee->delete();
        return "i am deleted";
    }
}
