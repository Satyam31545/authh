@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>
        #tale {
            text-align: center;
            display: flex;
            justify-content: center;
        }
    </style>
@endpush
@section('main-section')
    @php
        $tquantity = 0;
        $tprize = 0;
    @endphp
    <div id="tale"><a href="fpdf"><button>pdf</button></a></div>
    <div id="tale">


        <table id="customers">
            <tr>
                <th>product</th>
                <th>price</th>
                <th>quantity</th>
                <th>reject</th>

            </tr>
            @foreach ($products as $product)
                @php
                    $tquantity += $product->quantity;
                    $tprize += $product->products->prize;
                @endphp
                <tr>
                    <td>{{ $product->products->name }}</td>
                    <td>{{ $product->products->prize }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td><a href="{{ url('reject') }}/{{ $product->id }}"><button>reject</button></a></td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td>{{ $tprize }}</td>
                <td>{{ $tquantity }}</td>
            </tr>



        </table>
    </div>
@endsection
