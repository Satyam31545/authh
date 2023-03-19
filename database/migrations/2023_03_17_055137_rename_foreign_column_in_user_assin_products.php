<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameForeignColumnInUserAssinProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_assin_products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        $employees = DB::table('employees')->get(['id','user_id']);
        $user_assin_products = DB::table('user_assin_products')->get();
        foreach ($user_assin_products as $user_assin_product) {
$employee = $employees->where('user_id',$user_assin_product->user_id)->first()->id;

            DB::update('update user_assin_products set user_id = '.$employee.'  where id = '.$user_assin_product->id);
        }

        Schema::table('user_assin_products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_assin_products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        $employees = DB::table('employees')->get(['id','user_id']);
        $user_assin_products = DB::table('user_assin_products')->get();
        foreach ($user_assin_products as $user_assin_product) {
$employee = $employees->where('id',$user_assin_product->user_id)->first()->user_id;

            DB::update('update user_assin_products set user_id = '.$employee.' where id = '.$user_assin_product->id);
        }

        Schema::table('user_assin_products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
