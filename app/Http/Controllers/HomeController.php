<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Product;
use App\Models\User;
use App\Models\User_assin_product;
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
        $id = Auth::user()->id;
        $products = User_assin_product::where("user_id", $id)->with("products")->get();

        $data = compact('products');
        return view("myproduct")->with($data);
    }






}
