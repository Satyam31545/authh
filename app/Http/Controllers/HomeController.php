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
    public function __construct()
    {
        $this->middleware('permission:product-assign', ['only' => ['assign_product_p', 'assign_product']]);
        $this->middleware('permission:product-remove', ['only' => ['deassign_product']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('view')->with(['user'=>Auth::user()]);
    }
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function edit()
    {
        $id = Auth::user()->id;
        $emp = Employee::where('id', $id)->get();
        $data = compact('emp');
        return view('s_update')->with($data);
    }

    public function update(request $req)
    {
        try {
            $id = Auth::user()->id;
            $emp = employee::find($id);
            $emp->dob = $req['dob'];
            $emp->address = $req['address'];
            $emp->update();
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function assign_product($id)
    {

        $array = User_assin_product::where("user_id", $id)->pluck('product_id')->all();

        $toassign = Product::all()->except($array);

        $assigned = User_assin_product::where("user_id", $id)->with("products")->get();

        $data = compact('toassign', 'assigned', 'id');
        return view("assign_product")->with($data);
    }

    public function deassign_product($id)
    {
        DB::transaction(function () use ($id) {
            $u_p = User_assin_product::where("id", $id);
            $qu = $u_p->first();

//    log start
            Log::create([
                'changer' => Auth::user()->id,
                'change_holder' => $qu->user_id,
                'operation' => 'removed',
                'quantity' => $qu->quantity,
                'product_id' => $qu->product_id,
            ]);
// log end

            $pro = Product::find($qu->product_id);
            $pro->quantity = $pro->quantity + $qu->quantity;
            $pro->save();
            $u_p->delete();

        });
        return redirect()->back();
    }
    public function assign_product_p($id, request $req)
    {

        try {
            DB::table('user_assin_products')->insert(['user_id' => $id, 'product_id' => $req['product_id'], 'quantity' => $req['quantity']]);

            $pro = Product::find($req['product_id']);
            $pro->quantity = $pro->quantity - $req['quantity'];

            $pro->save();

//    log start
            Log::create([
                'changer' => Auth::user()->id,
                'change_holder' => $id,
                'operation' => 'added',
                'quantity' => $req['quantity'],
                'product_id' => $req['product_id'],
            ]);
// log end

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function myproduct()
    {
        $id = Auth::user()->id;
        $products = User_assin_product::where("user_id", $id)->with("products")->get();

        $data = compact('products');
        return view("myproduct")->with($data);
    }

// increase assined product

    public function increase_assined(request $req)
    {

        DB::transaction(function () use ($req) {
            $u_p = User_assin_product::find($req['add_id']);
            // $qu=$u_p->first();
            $quantity = $req["quantity"];

//  //    log start
            Log::create([
                'changer' => Auth::user()->id,
                'change_holder' => $u_p->user_id,
                'operation' => 'increase',
                'quantity' => $quantity,
                'product_id' => $u_p->product_id,
            ]);
//  // log end
            $pro = Product::find($u_p->product_id);

            $pro->quantity = $pro->quantity - $quantity;
            $pro->save();

            $u_p->quantity = $u_p->quantity + $quantity;
            $u_p->save();

        });

        return redirect()->back();

    }

//  return
    public function return_assined(request $req)
    {

        DB::transaction(function () use ($req) {
            $u_p = User_assin_product::find($req['add_id']);
            $quantity = $req["quantity"];

//  //    log start
            Log::create([
                'changer' => Auth::user()->id,
                'change_holder' => $u_p->user_id,
                'operation' => 'return',
                'quantity' => $quantity,
                'product_id' => $u_p->product_id,
            ]);
//  // log end
            $pro = Product::find($u_p->product_id);

            $pro->quantity = $pro->quantity + $quantity;
            $pro->save();

            $u_p->quantity = $u_p->quantity - $quantity;
            $u_p->save();

        });

        return redirect()->back();

    }
    // function for pdf is at ExportController


//  log
    public function mylogs(request $req)
    {
        $products = Product::get();
        $users = User::get();
        $logs = Log::get();
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
