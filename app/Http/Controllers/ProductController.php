<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
class ProductController extends Controller
{





    function __construct()
    {
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
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
    public function store(Request $req)
    {
        $val =  Validator::make($req['product'][0],[
            'name'=> 'required',
            'prize'=> 'required',
            'quantity'=> 'required',
            'description'=> 'required',
            'tax'=> 'required'
    ])->validate();
    // validator
try {
    Product::create($val);


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
    public function update(Request $req, Product $product)
    {
        try {
            $pro = $product;
        if ($req['name']!='') { $pro->name=$req['name']; }
        if ($req['prize']!='') { $pro->prize=$req['prize']; }
        if ($req['quantity']!='') {  $pro->quantity=$req['quantity']; }
        if ($req['tax']!='') {  $pro->tax=$req['tax']; }
 $pro->save(); 
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
        $product->delete();
        return redirect()->back();
    }
}
