<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('id_codes', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('code_char');
            $table->integer('code_num');
            $table->timestamps();
        });
        DB::table('id_codes')->insert(
            ['table_name' => 'employees', 'code_char' => 'emp', 'code_num' => 1000]
        );
        DB::table('id_codes')->insert(
            ['table_name' => 'products', 'code_char' => 'pro', 'code_num' => 1000]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('id_codes');
    }
}
