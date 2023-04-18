<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Product;
use App\Models\Employee;
use App\Models\UserAssinProduct;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-assign', ['only' => ['assign_product_p', 'assign_product']]);
        $this->middleware('permission:product-remove', ['only' => ['deassign_product']]);
    }
    public function create(Employee $employee)
    {

        $toassign = Product::all('id','name','quantity')->except($employee->UserAssignProducts->pluck('product_id')->all());

        $assigned = $employee->UserAssignProducts()->get()->load("product");
        $id=$employee->id;

        $data = compact('toassign', 'assigned', 'id');
        return view("assign_product")->with($data);
    }

    public function destroy(UserAssinProduct $id)
    {
        DB::transaction(function () use ($id) {

            $id->product()->update(['quantity'=>$id->product->quantity+ $id->quantity]);
            $id->delete();
//    log start
            Log::create([
                'changer_id' => Auth::user()->id,
                'change_holder_id' => $id->employee_id,
                'operation' => 'removed',
                'quantity' => $id->quantity,
                'product_id' => $id->product_id,
            ]);
// log end

        });
        return redirect()->back();
    }
    public function store(Employee $employee, request $req)
    {

        try {
            DB::transaction(function () use ($employee, $req) {

                $employee->UserAssignProducts()->create(['product_id' => $req['product_id'], 'quantity' => $req['quantity']]);


                $product = Product::find($req['product_id']);
                $product->update(['quantity'=>$product->quantity - $req['quantity']]);

//    log start
                Log::create([
                    'changer_id' => Auth::user()->id,
                    'change_holder_id' => $employee->id,
                    'operation' => 'added',
                    'quantity' => $req['quantity'],
                    'product_id' => $req['product_id'],
                ]);
// log end
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    // increase assined product

    public function increase_assined(request $req)
    {

        DB::transaction(function () use ($req) {
            $user_assin_product = UserAssinProduct::find($req['add_id']);

//  //    log start
            Log::create([
                'changer_id' => Auth::user()->id,
                'change_holder_id' => $user_assin_product->employee_id,
                'operation' => 'increase',
                'quantity' => $req["quantity"],
                'product_id' => $user_assin_product->product_id,
            ]);
//  // log end

$user_assin_product->product()->update(["quantity"=>$user_assin_product->product->quantity-$req["quantity"]]);
$user_assin_product->update(["quantity"=>$user_assin_product->quantity+$req["quantity"]]);

        });

        return redirect()->back();

    }

//  return
    public function return_assined(request $req)
    {

        DB::transaction(function () use ($req) {
            $user_assin_product = UserAssinProduct::find($req['add_id']);
 
//  //    log start
            Log::create([
                'changer_id' => Auth::user()->id,
                'change_holder_id' => $user_assin_product->employee_id,
                'operation' => 'return',
                'quantity' => $req["quantity"],
                'product_id' => $user_assin_product->product_id,
            ]);
//  // log end
            $user_assin_product->product()->update(["quantity"=>$user_assin_product->product->quantity+$req["quantity"]]);
            $user_assin_product->update(["quantity"=>$user_assin_product->quantity-$req["quantity"]]);

        });

        return redirect()->back();

    }

}
