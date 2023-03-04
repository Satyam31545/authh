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
            <th>role</th>

            <th>Authority</th>
        </tr>
        @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>

                <td>

                    @can('role-edit')
                        <a href="{{route('role.edit',['id'=>$role->id])}}"><button>edit</button></a>
                    @endcan

                </td>
            </tr>
        @endforeach




    </table>
@endsection
