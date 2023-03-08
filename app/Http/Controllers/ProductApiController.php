<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Validator;

use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['products'=>Product::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val =  Validator::make($request->all(),[
            'name'=> 'required',
            'prize'=> 'required',
            'quantity'=> 'required',
            'description'=> 'required',
            'tax'=> 'required'
    ]);
    if ($val->fails()) {    
        return response()->json($val->messages(), 200);
      }
        $product = Product::create($val->validated());
        return response()->json(['products'=>$product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['products'=>Product::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $val =  Validator::make($request->all(),[
            'name'=> 'required',
            'prize'=> 'required',
            'quantity'=> 'required',
            'description'=> 'required',
            'tax'=> 'required'
    ]);
    if ($val->fails()) {    
        return response()->json($val->messages(), 200);
      }
        $product =Product::find($id);
        $product->update($val->validated()); 
        return response()->json(['products'=>$product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['status'=>'deleted']);

    }
}
