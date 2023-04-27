<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\IdCode;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public $productService;
    public function __construct()
    {
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy', 'restoreDeletedProduct', "forceDelete"]]);
        $this->productService = new ProductService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view("Product.index")->with(['products' => Product::simplePaginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $idCode = IdCode::where("table_name", "products")->first();
        return view("product.create")->with(['id_code' => $idCode->code_char . $idCode->code_num]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $req): JsonResponse
    {
        $req = $req->validated();
        try {
            $this->productService->store($req);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
        return response()->json([
            'status' => 'success',
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product): View
    {
        return view('Product.update')->with(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $req, Product $product): JsonResponse
    {

        try {
            $this->productService->update($req->validated(), $product);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
        return response()->json([
            'status' => 'success',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $this->productSevice->destroy($product);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }
    public function deletedProducts(): View
    {
        return view("Product.deleted")->with(['products' => Product::onlyTrashed()->get()]);
    }
    public function forceDelete(int $id)
    {
        try {
            $product = Product::onlyTrashed()->find($id);
            if (!is_null($product)) {
                $product->forceDelete();
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }

        return redirect()->back()->with(json_encode([
            'status' => 'success',
        ]));
    }
    public function restoreDeletedProduct(int $id)
    {

        try {
            $product = Product::onlyTrashed()->find($id);
            if (!is_null($product)) {
                $product->restore();
            }
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
