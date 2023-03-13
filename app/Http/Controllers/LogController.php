<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //  log
    public function mylogs(request $req)
    {
        $products = Product::get();
        $users = User::get();
        $logs = Log::with("change_holder")->with("product")->with("changer")->get();
        if ($req['changer'] != "") {
            $logs = $logs->where('changer', $req['changer']);
        }
        if ($req['change_holder'] != "") {
            $logs = $logs->where('change_holder', $req['change_holder']);
        }
        if ($req['product'] != "") {
            $logs = $logs->where('product_id', $req['product']);
        }
        if ($req['date'] != "") {
            $dates = date_create($req['date']);
            date_add($dates, date_interval_create_from_date_string("1 days"));
            $logs = $logs->where('created_at', '<', $dates)->where('created_at', '>', $req['date']);
        }
        $data = compact('logs', 'products', 'users');
        return view('log')->with($data);
    }
}
