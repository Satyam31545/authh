<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\User;
use App\Models\Employee;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;

class EmployeeApiController extends Controller
{
    public  $employeeService;
    public function __construct()
    {
        $this->employeeService=new EmployeeService;
    }
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
            $this->employeeService->store($req);
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

        $request = $request->validated();
        try {
            $this->employeeService->update($request,$employee);
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

        $this->employeeService->destroy($employee);

        return response()->json(['message' => "employee deleted successfully"], 200);

    }
}