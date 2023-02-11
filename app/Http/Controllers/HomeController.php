<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id= Auth::user()->id;
        $my_employee = Employee::with("families")->with("education")->where('id',$id)->first();
         $role=  User::find($my_employee->user_id)->getRoleNames()[0];
        $data = compact('my_employee','role'); 
       
       
        return  view('view')->with($data);
    }
    public function logout(){
        session()->flush();
        return redirect('/');
       }


       public function update(){
        $id= Auth::user()->id;
        $emp = Employee::where('id',$id)->get();
        $data = compact('emp');
    return  view('s_update')->with($data);
       } 

       public function p_update(request $req){
        try {
                    $id= Auth::user()->id;
        $emp = employee::find($id);
        $emp->dob = $req['dob'];
        $emp->address = $req['address'];
        $emp->save(); 
    } catch (\Exception $e) {
        return $e->getMessage();
        }

     }

}
