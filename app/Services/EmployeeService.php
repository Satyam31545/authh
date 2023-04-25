<?php
namespace App\Services;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EmployeeRequest;
  
class EmployeeService
{
    public function store(array $req)
    {

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

    }

    public function update(array $req, Employee $employee)
    {

            DB::transaction(function () use ($req, $employee) {

                $employee->update($req);
                DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
                $user = User::find($employee->user_id);
                $user->assignRole([$req['role']]);
            });
    }
    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            $employee->families()->delete();
            $employee->education()->delete();
            DB::table('model_has_roles')->where('model_id', $employee->user_id)->delete();
            $employee->user->delete();
            $employee->delete();
        });

    }
}