@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 80%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
@endpush
@section('main-section')
@can('product-create')
<a href="product/create"><button>create</button></a>
@endcan

<table id="customers">
    <tr>
      <th>product</th>
      <th>price</th>
      <th>quantity</th>
      <th>Authority</th>
    </tr>
    @foreach ($products as $product)
 <tr>
              <td>{{$product->name}}</td>
      <td>{{$product->prize}}</td>
      <td>{{$product->quantity}}</td>
      <td>        
        @can('product-delete')
 <form action="{{ url('product/'.$product->id)}}" method="POST">
            @csrf 
            @method('DELETE')
            <button>delete</button>
            </form> 
@endcan
       
            @can('product-edit')
<a href="product/{{$product->id}}/edit"><button>edit</button></a>
@endcan
        
         </td>
 </tr>
    @endforeach
   

   
   
  </table>
  
@endsection
