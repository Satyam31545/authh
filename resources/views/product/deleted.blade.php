@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 80%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

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
    <table id="customers">
        <tr>
            <th>S.No</th>
            <th>product</th>
            <th>price</th>
            <th>description</th>
            <th>tax</th>
            <th>quantity</th>
            <th>Authority</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->prize }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->tax }}</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    @can('product-delete')
                        <form action="{{route('product_deleted_permanent',['product'=>$product->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('are you sure want to delete product ?')">delete parmanent</button>
                        </form>
                        {{-- <form action="{{route('product_restore',['product'=>$product->id])}}" method="get">
                            <button onclick="return confirm('are you sure want to restore product ?')">restore</button>
                        </form> --}}
                        <a href="{{route('product_restore',['product'=>$product->id])}}"><button>restore</button></a>
                    @endcan


                </td>
            </tr>
        @endforeach




    </table>
@endsection
