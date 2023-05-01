<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->string('request_id');
            $table->string('remark');
            $table->enum('status', ['active', 'deactive', 'fulfilled'])->default("active");
            $table->date('due_date');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
        Schema::create('requested_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_request_id');
            $table->integer('quantity');
            $table->foreign('product_request_id')->references('id')->on('product_requests')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        DB::table('id_codes')->insert(
            ['table_name' => 'product_requests', 'code_char' => 'req', 'code_num' => 1000]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('id_codes')->where('table_name', 'requests')->delete();
        Schema::dropIfExists('product_requests');
        Schema::dropIfExists('requests');
    }
}
