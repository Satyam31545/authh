<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_id')->default("pro0");
        });
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $id_code = DB::table('id_codes')->where('table_name', 'products')->first();

            DB::update('update products set product_id = "' . $id_code->code_char . $id_code->code_num . '" where id =' . $product->id);
            DB::table('id_codes')->where("table_name", "products")->increment('code_num');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
}
