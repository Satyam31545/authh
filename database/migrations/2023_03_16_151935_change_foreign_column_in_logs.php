<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class ChangeForeignColumnInLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign(['changer']);
            $table->dropForeign(['change_holder']);
        });

        $employees = DB::table('employees')->get(['id','user_id']);
        $logs = DB::table('logs')->get();
        foreach ($logs as $log) {
$changer = $employees->where('user_id',$log->changer)->first()->id;
$change_holder = $employees->where('user_id',$log->change_holder)->first()->id;

            DB::update('update logs set changer = '.$changer.',change_holder = '.$change_holder.' where id = '.$log->id);
        }

        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('changer')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('change_holder')->references('id')->on('employees')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign(['changer']);
            $table->dropForeign(['change_holder']);
        });

        $employees = DB::table('employees')->get(['id','user_id']);
        $logs = DB::table('logs')->get();
        foreach ($logs as $log) {
$changer = $employees->where('id',$log->changer)->first()->user_id;
$change_holder = $employees->where('id',$log->change_holder)->first()->user_id;

            DB::update('update logs set changer = '.$changer.',change_holder = '.$change_holder.' where id = '.$log->id);
        }

        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('changer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('change_holder')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
