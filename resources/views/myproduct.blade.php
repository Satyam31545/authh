@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>


</style>
@endpush
@section('main-section')
@can('product-create')
<a href="product/create"><button>create</button></a>
@endcan
@php
    $tquantity=0;
    $tprize=0;
@endphp
<table id="customers">
    <tr>
      <th>product</th>
      <th>price</th>
      <th>quantity</th>

    </tr>
    @foreach ($products as $product)
@php
       $tquantity+=$product->products->quantity;
    $tprize+=$product->products->prize; 
@endphp
 <tr>
              <td>{{$product->products->name}}</td>
      <td>{{$product->products->prize}}</td>
      <td>{{$product->products->quantity}}</td>
 </tr>
    @endforeach
    <tr>
        <td>Total</td>
<td>{{$tprize}}</td>
<td>{{$tquantity}}</td>
</tr>

   
   
  </table>
  
@endsection
