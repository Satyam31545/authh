<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\IdCode;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public  $productService;
    public function __construct()
    {
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy', 'product_restore', "product_deleted_permanent"]]);
        $this->productService=new ProductService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("Product.index")->with(['products' =>  Product::simplePaginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_code = IdCode::where("table_name", "products")->first();
        return view("product.create")->with(['id_code' => $id_code->code_char . $id_code->code_num]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $req)
    {
        $req=$req->validated();
        try {
            $this->productService->store($req);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
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
    public function update(ProductRequest $req, Product $product)
    {

        try {
            $this->productService->update($req->validated(),$product);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productService->destroy($product);
        return redirect()->back();
    }
    public function products_delete()
    {
        return view("Product.deleted")->with(['products' => Product::onlyTrashed()->get()]);
    }
    public function product_deleted_permanent($id)
    {
        $product = Product::withTrashed()->find($id);
        if (!is_null($product)) {
            $product->forceDelete();
        }
        return redirect()->back();

    }
    public function product_restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        if (!is_null($product)) {
            $product->restore();
        }
        return redirect()->back();
    }
}
