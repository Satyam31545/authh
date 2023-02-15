<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

        #customers tr:nth-child(odd) {
            background-color: #ff8484;
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
</head>

<body>
    @php
        $tquantity = 0;
        $tprize = 0;
    @endphp
    <table id="customers">
        <tr>
            <th>product</th>
            <th>price</th>
            <th>quantity</th>

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
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td>{{ $tprize }}</td>
            <td>{{ $tquantity }}</td>
        </tr>



    </table>
</body>

</html>
