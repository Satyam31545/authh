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
    </style>
@endpush
@section('main-section')
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
