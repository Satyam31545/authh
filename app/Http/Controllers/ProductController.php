<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

use Validator;
use DB;
class ProductController extends Controller
{





    function __construct()
    {
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy','product_restore',"product_deleted_permanent"]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view("Product.index")->with(['products'=>Product::all()]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view("product.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $req)
    {

try {
    Product::create($req->validated());


} catch (\Exception $e) {
return $e->getMessage();
}


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return  view('Product.update')->with(['product'=>$product]);  
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
            $pro = $product;
 $pro->update($req->validated()); 
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
        DB::transaction(function () use ($product) {
        $product->delete();
        $product->UserAssignProducts()->delete();
      
       
        });
          return redirect()->back();
    }
    public function products_delete()
    {
        return  view("Product.deleted")->with(['products'=>Product::onlyTrashed()->get()]);  
    }
    public function product_deleted_permanent($id)
    {
        $product= Product::withTrashed()->find($id);
        if (!is_null($product)) {
            $product->forceDelete();
        }
        return redirect()->back();

    }
    public function product_restore($id)
    {
      $product= Product::onlyTrashed()->find($id);
      if (!is_null($product)) {
        $product->restore();
      }
        return redirect()->back();
    }
}
