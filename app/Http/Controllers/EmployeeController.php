<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Validator;
use App\Models\User;
use App\Models\IdCode;
use App\Models\Employee;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    public  $employeeService;
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->employeeService=new EmployeeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('all_emp')->with(['employees' => $this->employeeService->index()]);
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
        $this->employeeService->store($req);
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
        return  $this->employeeService->show($employee);
       
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
        $req = $req->validated();
        try {
          $this->employeeService->update($req,$employee);
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
        return  $this->employeeService->destroy($employee);

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
