@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>
        #tale {
            text-align: center;
            display: flex;
            justify-content: center;
        }

        #submit {
            width: 75px;
            background-color: red;
            color: white;
            border-radius: 0px 20px 20px 0px;
        }

        #id_code {
            width: 100px;
        }
    </style>
@endpush
@section('main-section')
    <div id="tale">


        <table id="customers">
            <tr>
                <th>Table name</th>
                <th>Id code</th>
                <th>Operation</th>

            </tr>
            @forelse ($id_codes as $id_code)
                <tr>
                    <td>{{ $id_code->table_name }}</td>
                    <td>{{ $id_code->code_char }}</td>
                    <td>
                        <form id="form" action="{{ route('id_code.update', ['idcode' => $id_code->id]) }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @method('post')
                            <input type="hidden" name="id_code_id" value="{{ $id_code->id }}">
                            <input type="text" placeholder="code..." id="id_code" name="id_code">


                            <input type="submit" name="submit" id="submit" value="Update">
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">no data found</td>
                </tr>
            @endforelse




        </table>
    </div>
@endsection
