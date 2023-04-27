<?php

if (!function_exists('Id_code')) {
    function Id_code(string $table,string $code)
    {
        $id_code = \DB::table('id_codes')->where("table_name", $table)->first();
        if ($id_code->code_char . $id_code->code_num == $code) {
            \DB::table('id_codes')->where("table_name", $table)->increment('code_num');
        }
    }
}
