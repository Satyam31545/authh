<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInUserAssinProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_assin_products', function (Blueprint $table) {
           $table->renameColumn('user_id', 'employee_id');
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
           $table->renameColumn('employee_id', 'user_id');
        });
    }
}
