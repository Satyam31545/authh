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

        #date {
            width: 120px;
        }

        #submit {
            width: 80px;
            border-radius: 20px 20px 20px 20px;
            background-color: red;
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
                <option value="">changer</option>

                @foreach ($employees as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach


            </select>
            <select name="change_holder">
                <option value="">change_holder</option>

                @foreach ($employees as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="date" name="date" id="date">
            <input type="submit" value="Filter" id="submit">
        </form>
        @php
            $i = 0;
        @endphp
        <form action="{{ route('excel') }}" method="get">
            @foreach ($logs as $log)
                <input type="hidden" name="data[{{ $i }}][changer]" value="{{ $log->changer->id }}">
                <input type="hidden" name="data[{{ $i }}][change_holder]"
                    value="{{ $log->change_holder->name }}">
                <input type="hidden" name="data[{{ $i }}][quantity]" value="{{ $log->quantity }}">
                <input type="hidden" name="data[{{ $i }}][operation]" value="{{ $log->operation }}">
                <input type="hidden" name="data[{{ $i++ }}][time]" value="{{ $log->created_at }}">
            @endforeach
            <input type="submit" value="Export" id="submit">
        </form>
    </div>

    <div id="logs">


        <table id="customers">
            <tr>
                <th>S.No</th>
                <th>changer</th>
                <th>change_holder</th>
                <th>product</th>
                <th>quantity</th>
                <th>operation</th>
                <th>time</th>

            </tr>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a
                            href="{{ route('employee.show', ['employee' => $log->changer->id]) }}">{{ $log->changer->name }}</a>
                    </td>
                    <td><a
                            href="{{ route('employee.show', ['employee' => $log->change_holder->id]) }}">{{ $log->change_holder->name }}</a>
                    </td>
                    <td>
{{!$log->product ? "Product deleted" : $log->product->name}}
                    
                     </td>
                    <td>{{ $log->quantity }}</td>
                    <td>{{ $log->operation }}</td>
                    <td>{{ $log->created_at }}</td>

                </tr>
                @empty 
                <tr><td colspan="7"><p>no data found</p></td></tr>
            @endforelse




        </table>
    </div>
@endsection
