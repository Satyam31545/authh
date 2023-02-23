@extends('layouts.main')

@push('title')
    <title>EMS | Log</title>
    <style>
        #tale {
            text-align: center;
            display: flex;
            justify-content: center;
        }

        a {
            text-decoration: none;
        }

        #logs {
            text-align: center;
            display: flex;
            justify-content: center;
        }

        #search {
            display: flex;
            justify-content: center;
        }
        #date{
            width: 120px;
        }
        #submit{
            width: 80px;
            border-radius: 20px 20px 20px 20px;
            background-color:  red;
            color: white;
            font-size: 18px;

        }
    </style>
@endpush
@section('main-section')
    <div id="search">
        <form action="/mylogs" method="get">
            <select name="product">
                <option value="">product</option>

                @foreach ($products as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach


            </select>
            <select name="changer">
                <option value="" >changer</option>

                @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->employees['name'] }}</option>
                @endforeach


            </select>
            <select name="change_holder">
                <option value="" >change_holder</option>

                @foreach ($users as $item)
                    <option value="{{ $item->id }}">{{ $item->employees['name'] }}</option>
                @endforeach
            </select>
            <input type="date" name="date" id="date">
        <input type="submit" value="Filter" id="submit">
        </form>

    </div>

    <div id="logs">


        <table id="customers">
            <tr>
                <th>changer</th>
                <th>change_holder</th>
                <th>product</th>
                <th>quantity</th>
                <th>operation</th>
                <th>time</th>

            </tr>
            @foreach ($logs as $log)
                <tr>
                    <td><a href="employee/{{ $log->users[0]->employees->id }}">{{ $log->users[0]->employees->name }}</a></td>
                    <td><a href="employee/{{ $log->myusers[0]->employees->id }}">{{ $log->myusers[0]->employees->name }}</a>
                    </td>
                    <td>{{ $log->products[0]->name }}</td>
                    <td>{{ $log->quantity }}</td>
                    <td>{{ $log->operation }}</td>
                    <td>{{ $log->created_at }}</td>

                </tr>
            @endforeach




        </table>
    </div>
@endsection
