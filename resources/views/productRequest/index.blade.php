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
    @can('role-create')
        <a href="role/create"><button>create</button></a>
    @endcan
    <table id="customers">
        <tr>
            <th>S.no.</th>
            <th>employee</th>
            <th>remark</th>
            <th>due date</th>
            <th>created at</th>
            <th>status</th>
            <th>operation</th>
        </tr>
        @forelse ($productRequests as $productRequest)
            <tr style="{{ $productRequest->due_date < date('Y-m-d') ? 'color:red' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $productRequest->employee->name }}</td>
                <td>{{ $productRequest->remark }}</td>
                <td>{{ $productRequest->due_date }}</td>
                <td>{{ $productRequest->created_at }}</td>
                <td>{{ $productRequest->status }}</td>
                <td><a
                        href="{{ route('productRequest.inactivate', ['productRequest' => $productRequest->id]) }}"><button>Inactivate</button></a><a
                        href="{{ route('productRequest.edit', ['productRequest' => $productRequest->id]) }}"><button>Assign</button></a>
                </td>

            </tr>
            @empty
            <tr><td colspan="7">no data found</td></tr>
        @endforelse




    </table>
@endsection
