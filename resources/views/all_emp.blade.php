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
        hr{
            height: 2px;
            width: 90%;
            background-color: red;
            border: 0px;
        }
    </style>
@endpush
@section('main-section')
    <div id="detail">
        <div id="persional">
            <div id="allhead">Persional</div>

            <div id="paginate">
                <a href="{{ $employees->previousPageUrl() }}"><button><< previous</button></a>
               <b> {{ $employees->currentPage() }}</b>
                <a href="{{ $employees->nextPageUrl() }}"><button>next >></button></a>
                
                </div>
            @foreach ($employees as $item)
                @can('user-list')
                    <p> <a href="{{route('employee.show',['employee'=>$item->id]) }}">
                    @endcan
                   {{ $item->name }}
                    @can('user-list')
                    </a></p>
                @endcan
                <p>desigination - {{ $item->desigination }}</p>
                <div id="btn">
                    @can('product-assign')
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
