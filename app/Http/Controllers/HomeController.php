<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Product;
use App\Models\User;
use App\Models\UserAssinProduct;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('view')->with(['user'=>Auth::user()]);
    }





    public function myproduct()
    {
        return view("myproduct")->with(['products'=>UserAssinProduct::where("employee_id", Auth::user()->id)->get()->load("product")]);
    }






}
