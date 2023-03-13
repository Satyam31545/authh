<?php

namespace App\Http\Controllers;
use App\Models\UserAssignProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Log;
use DB;
use Illuminate\Support\Facades\Auth;

class AssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-assign', ['only' => ['assign_product_p', 'assign_product']]);
        $this->middleware('permission:product-remove', ['only' => ['deassign_product']]);
    }
    public function assign_product($id)
    {

        $array = UserAssignProduct::where("user_id", $id)->pluck('product_id')->all();

        $toassign = Product::all()->except($array);

        $assigned = UserAssignProduct::where("user_id", $id)->with("products")->get();

        $data = compact('toassign', 'assigned', 'id');
        return view("assign_product")->with($data);
    }

    public function deassign_product($id)
    {
        DB::transaction(function () use ($id) {
            $u_p = UserAssignProduct::where("id", $id);
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
            DB::table('UserAssignProducts')->insert(['user_id' => $id, 'product_id' => $req['product_id'], 'quantity' => $req['quantity']]);

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


    // increase assined product

    public function increase_assined(request $req)
    {

        DB::transaction(function () use ($req) {
            $u_p = UserAssignProduct::find($req['add_id']);
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
            $u_p = UserAssignProduct::find($req['add_id']);
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

}
