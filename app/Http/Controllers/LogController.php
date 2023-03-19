<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //  log
    public function mylogs(request $request)
    {
        $products = Product::get();
        $employees = Employee::get();

        $logs = Log::
            when($request->changer, function ($query) use ($request) {

                return $query->where('changer_id', $request->changer);

            })->when($request->change_holder, function ($query) use ($request) {

            return $query->where('change_holder_id', $request->change_holder);

        })->when($request->product, function ($query) use ($request) {

            return $query->where('product_id', $request->product);

        })->when($request->date, function ($query) use ($request) {

            $dates = date_create($request->date);
            date_add($dates, date_interval_create_from_date_string("1 days"));

            return $query->where('created_at', '<', $dates)->where('created_at', '>', $request->date);

        })->get()->load(["change_holder:id,name", "product:id,name", "changer:id,name"]);

        $data = compact('logs', 'products', 'employees');
        return view('log')->with($data);
    }
}
