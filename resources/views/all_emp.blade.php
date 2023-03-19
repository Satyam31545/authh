@extends('layouts.main')

@push('title')
    <title>EMS | View</title>
    <style>
        #login_box,
        #persional,
        #educational,
        #experience,
        #family {
            display: grid;
        }

        #detail {
            padding-left: 25px;


        }

        #allhead {
            text-align: center;
            font-size: 30px;
            color: red;
        }

        #btn {
            display: block;
        }

        a {
            text-decoration: none;
        }
    </style>
@endpush
@section('main-section')
    <div id="detail">
        <div id="persional">
            <div id="allhead">Persional</div>

            @foreach ($my_employee as $item)
                @can('product-assign')
                    <a href="{{route('employee.show',['employee'=>$item->id]) }}">
                    @endcan
                    <p>name - {{ $item->name }}</p>
                    @can('product-assign')
                    </a>
                @endcan
                <p>desigination - {{ $item->desigination }}</p>
                <div id="btn">
                    @can('user-list')
                        <a href="{{route('assign',['employee'=>$item->id])}}"><button>Assign Product</button></a>
                    @endcan
                    @can('user-edit')
                        <a href="{{route('employee.edit',['employee'=>$item->id])}}"><button>edit</button></a>
                    @endcan
                    @can('user-delete')
                        <form action="{{route('employee.destroy',['employee'=>$item->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('are you sure want to delete employee ?')" >delete</button>
                        </form>
                    @endcan

                </div>
                <hr>
            @endforeach


        </div>




    </div>
@endsection
