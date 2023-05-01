<?php

namespace App\Http\Controllers;

use App\Models\IdCode;
use App\Models\Product;
use App\Models\ProductRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Validator;

class ProductRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view("productRequest.index")->with(['productRequests' => ProductRequest::where("status", "active")->get()->load(['requestedProducts'])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $idCode = IdCode::where("table_name", "product_requests")->first();
        return view('productRequest.create')->with(['id_code' => $idCode->code_char . $idCode->code_num, 'products' => Product::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'request_id' => 'required',
            'due_date' => 'required',
            'remark' => 'required',
            'product_request.*.product_id' => 'nullable',
            'product_request.*.quantity' => 'nullable',
        ])->validate();
        try {
            DB::transaction(function () use ($validated) {
                Id_code('product_requests', $validated['request_id']);
                $validated['employee_id'] = Auth::user()->employee->id;

                $productRequest = ProductRequest::create($validated);

                if (isset($validated['product_request'])) {
                    foreach ($validated['product_request'] as $requestedProduct) {
                        $productRequest->requestedProducts()->create($requestedProduct);
                    }
                }
            });

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}
        return response()->json([
            'status' => 'success',
        ], 201);
    }

    public function inactivate(ProductRequest $productRequest)
    {
        try {
            $productRequest->update(["status" => "inactive"]);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}
        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRequest $productRequest): View
    {
        return view("productRequest.update")->with(['productRequest' => $productRequest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRequest $productRequest): JsonResponse
    {

        $validated = Validator::make($request->all(), [
            'quantity.*' => 'required',
        ])->validate();
        try {
            DB::transaction(function () use ($validated, $productRequest) {
                foreach ($productRequest->requestedProducts as $key => $requestedProduct) {
                    // decreating from request table
                    $requestedProduct->decrement('quantity', $validated["quantity"][$key]);
                    // decreating from product table
                    $requestedProduct->product()->decrement('quantity', $validated["quantity"][$key]);
                    // adding to assign product table
                    $assignedProduct = $productRequest->employee->UserAssignProducts()->where('product_id', $requestedProduct->product_id)->first();
                    if ($assignedProduct) {
                        // for existing entry
                        $assignedProduct->increment('quantity', $validated["quantity"][$key]);
                    } else {
                        // for new entry
                        $productRequest->employee->UserAssignProducts()->create(["product_id" => $requestedProduct->product_id, "quantity" => $validated["quantity"][$key]]);
                    }
                }
                //   changing status of product request
                if (!empty($validated["status"])) {
                    $productRequest->update(["status" => "inactive"]);
                } else {
                    if (!$productRequest->requestedProducts->sum("quantity")) {
                        $productRequest->update(["status" => "fulfilled"]);
                    }
                }
            });
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);}
        return response()->json([
            'status' => 'success',
        ], 201);
    }

}
