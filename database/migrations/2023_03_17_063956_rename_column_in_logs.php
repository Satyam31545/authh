<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
           $table->renameColumn('changer', 'changer_id');
           $table->renameColumn('change_holder', 'change_holder_id');
            
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
            $table->renameColumn('changer_id', 'changer');
            $table->renameColumn('change_holder_id', 'change_holder');
            
        });
    }
}
