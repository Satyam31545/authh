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
                    <a href="{{ url('assign_product') }}/{{ $item->user_id }}">
                    @endcan
                    <p>name - {{ $item->name }}</p>
                    @can('product-assign')
                    </a>
                @endcan
                <p>desigination - {{ $item->desigination }}</p>
                <div id="btn">
                    @can('user-list')
                        <a href="employee/{{ $item->id }}"><button>show</button></a>
                    @endcan
                    @can('user-edit')
                        <a href="employee/{{ $item->id }}/edit"><button>edit</button></a>
                    @endcan
                    @can('user-delete')
                        <form action="{{ url('employee/' . $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button>delete</button>
                        </form>
                    @endcan
                    @can('family-create')
                        <a href="family/{{ $item->id }}"><button>add family</button></a>
                    @endcan
                    @can('education-create')
                        <a href="education/{{ $item->id }}"><button>add education</button></a>
                    @endcan


                </div>
                <hr>
            @endforeach


        </div>




    </div>
@endsection
