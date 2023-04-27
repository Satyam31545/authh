<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\IdCode;
use App\Models\User;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Validator;

class EmployeeController extends Controller
{
    public $employeeService;
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->employeeService = new EmployeeService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): View
    {
        return view('all_emp')->with(['employees' => Employee::simplePaginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $idCode = IdCode::where("table_name", "employees")->first();
        return view('create')->with(['id_code' => $idCode->code_char . $idCode->code_num]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $req): JsonResponse
    {
        try {
            $this->employeeService->store($req->validated());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}
        return response()->json([
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee): View
    {
        return view('view')->with(['user' => $employee->user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee): View
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
    public function update(EmployeeRequest $req, Employee $employee): JsonResponse
    {
        $req = $req->validated();
        try {
            $this->employeeService->update($req, $employee);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}
        return response()->json([
            'status' => 'success',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            $this->employeeService->destroy($employee);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}

        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }

    public function edit_s(): View
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
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}
        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }
}
