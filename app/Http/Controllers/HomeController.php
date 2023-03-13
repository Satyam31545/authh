<?php

namespace App\Http\Controllers;

use App\Models\UserAssignProduct;
use Illuminate\Support\Facades\Auth;

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
        return view('view')->with(['employee' => Auth::user()->employee]);
    }





    public function myproduct()
    {
        $id = Auth::user()->id;
        $products = UserAssignProduct::where("user_id", $id)->with("products")->get();

        $data = compact('products');
        return view("myproduct")->with($data);
    }
}
