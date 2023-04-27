<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use App\Models\Product;
use App\Models\UserAssinProduct;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-assign', ['only' => ['assign_product_p', 'assign_product']]);
        $this->middleware('permission:product-remove', ['only' => ['deassign_product']]);
    }
    public function create(Employee $employee): View
    {

        $productsToAssign = Product::all('id', 'name', 'quantity')->except($employee->UserAssignProducts->pluck('product_id')->all());

        $assignedProducts = $employee->UserAssignProducts()->get()->load("product");
        $id = $employee->id;

        $data = compact('productsToAssign', 'assignedProducts', 'id');
        return view("assign_product")->with($data);
    }

    public function deassignProduct(UserAssinProduct $userAssignProduct)
    {

        try {
            DB::transaction(function () use ($userAssignProduct) {
                $userAssignProduct->product()->increment('quantity', $userAssignProduct->quantity);
                $userAssignProduct->delete();
//    log start
                Log::create([
                    'changer_id' => Auth::user()->id,
                    'change_holder_id' => $userAssignProduct->employee_id,
                    'operation' => 'removed',
                    'quantity' => $userAssignProduct->quantity,
                    'product_id' => $userAssignProduct->product_id,
                ]);
// log end

            });
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }
    public function assignProduct(Employee $employee, request $req): JsonResponse
    {

        try {
            DB::transaction(function () use ($employee, $req) {

                $employee->UserAssignProducts()->create($req->all());

                $product = Product::find($req['product_id']);
                $product->decrement('quantity', $req['quantity']);

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
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
        return response()->json([
            'status' => 'success',
        ], 201);
    }

    // increase assined product

    public function increaseAssignedProduct(request $req)
    {
        try {
            DB::transaction(function () use ($req) {
                $userAssignProduct = UserAssinProduct::find($req['add_id']);

//  //    log start
                Log::create([
                    'changer_id' => Auth::user()->id,
                    'change_holder_id' => $userAssignProduct->employee_id,
                    'operation' => 'increase',
                    'quantity' => $req["quantity"],
                    'product_id' => $userAssignProduct->product_id,
                ]);
//  // log end

                $userAssignProduct->product()->decrement('quantity', $req['quantity']);
                $userAssignProduct->increment('quantity', $req['quantity']);

            });
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }

//  return
    public function returnAssignedProduct(request $req)
    {

        try {
            DB::transaction(function () use ($req) {
                $userAssignProduct = UserAssinProduct::find($req['add_id']);

//  //    log start
                Log::create([
                    'changer_id' => Auth::user()->id,
                    'change_holder_id' => $userAssignProduct->employee_id,
                    'operation' => 'return',
                    'quantity' => $req["quantity"],
                    'product_id' => $userAssignProduct->product_id,
                ]);
//  // log end
                $userAssignProduct->product()->increment('quantity', $req['quantity']);
                $userAssignProduct->decrement('quantity', $req['quantity']);

            });
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));

    }

}
