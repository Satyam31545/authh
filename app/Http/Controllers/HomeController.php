<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use App\Models\UserAssinProduct;
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
    public function index():View
    {
        return view('view')->with(['user' => Auth::user()]);
    }
    public function myproduct():View
    {
        return view("myproduct")->with(['products' => UserAssinProduct::where("employee_id", Auth::user()->id)->get()->load("product")]);
    }

}
