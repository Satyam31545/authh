@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>
        #tale {
            text-align: center;
            display: flex;
            justify-content: center;
        }
        #add {
            width: 75px;
            background-color: red;
            color: white;
            border-radius: 0px 20px 20px 0px;
        }
        #quantity {
            width: 100px;
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
                    <td>
                        <form id="form1" action="{{ url('return_assined') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input type="hidden" name="add_id" value="{{ $product->id }}">
                            <input type="number" placeholder="max({{ $product->quantity }})" id="quantity"
                                name="quantity" max="{{ $product->quantity }}">


                            <input type="submit" name="submit" id="add" value="RETURN">
                        </form>
                    </td>
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
