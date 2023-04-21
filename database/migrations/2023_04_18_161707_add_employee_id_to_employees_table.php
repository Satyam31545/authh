<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('employee_id')->default("emp0");
        });
        $employees = DB::table('employees')->get();
        foreach ($employees as $employee) {
            $id_code = DB::table('id_codes')->where('table_name', 'employees')->first();

            DB::update('update employees set employee_id = "' . $id_code->code_char . $id_code->code_num . '" where id =' . $employee->id);
            DB::table('id_codes')->where("table_name", "employees")->increment('code_num');

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employee_id');

        });
    }
}
