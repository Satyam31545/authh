@extends('layouts.main')

@push('title')
    <title>
        EMS | Create</title>
    <style>
        body {
            background-color: #df9ef5;
            margin: 0px;

        }


        #login {
            height: 550px;
            width: 400px;
            box-shadow: 0.5px 0.5px 3px 3px #888888;
            background-color: #ffffff;
        }

        select {
            height: 30px;
            border: 0px solid black;
            font-size: 15px;
            box-shadow: 0.5px 3px 3px #888888;
            width: 220px;

        }

        #quantity {
            width: 100px;
        }

        #assigned {
            display: block;
        }

        #add {
            width: 45px;
            background-color: red;
            color: white;
            border-radius: 0px 20px 20px 0px;
        }
    </style>
@endpush
@section('main-section')
    <div id="login_box">

        <div id="login">
            <div id="login_h">
                Assign product
            </div>

            <div id="form_container">
                <div id="forms">

                    <div id="assigned">
                        @foreach ($assigned as $item)
                            <p> {{ $item->products->name }} @can('product-remove')
                                    <a href="{{ url('deassign_product') }}/{{ $item->id }}"><button>remove</button>
                                    </a>
                                @endcan
                            </p>

                            <form id="form1" action="{{ url('increase_assined') }}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="hidden" name="add_id" value="{{ $item->id }}">
                                <input type="number" placeholder="max({{ $item->products->quantity }})" id="quantity"
                                    name="quantity" max="{{ $item->products->quantity }}">


                                <input type="submit" name="submit" id="add" value="ADD">
                            </form>
                        @endforeach


                    </div>

                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">

                            <select name="product_id" id="product_id">
                                <option value="" class="0">product</option>

                                @foreach ($toassign as $item)
                                    <option value="{{ $item->id }}" class="{{ $item->quantity }}">{{ $item->name }}
                                    </option>
                                @endforeach


                            </select>
                        </div>
                        <div class="form-group" id="quantitym">

                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="REGISTER">
                        </div>
                        <div id="error"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="http://127.0.0.1:8000/jquary.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  --}}
    <script>
        jQuery('#form').submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{ url('/assign_product') }}/{{ $id }}",
                type: "POST",
                data: jQuery('#form').serialize(),
                success: function(result) {
                    if (result == "") {
                        window.location = "{{ url('/assign_product') }}/{{ $id }}";
                    } else {
                        // console.log(result);
                        $("#error").text(result);

                    }

                }
            });
        });

        // jQuery('#form1').submit(function(e) {
        //     e.preventDefault();
        //     jQuery.ajax({
        //         headers: {
        //             'X-CSRF-Token': $('input[name="_token"]').val()
        //         },
        //         url: "{{ url('/increase_assined') }}",
        //         type: "POST",
        //         data: jQuery('#form1').serialize(),
        //         success: function(result) {
        //             if (result == "") {
        //                 // window.location = "{{ url('/assign_product') }}/{{ $id }}";
        //             } else {
        //                 // console.log(result);
        //                 $("#error").text(result);

        //             }

        //         }
        //     });
        // });


        element = document.getElementById('product_id');

        element.addEventListener('change', function() {


            var ma = eval($(":selected")[0].className)
            document.getElementById('quantitym').innerHTML = '<input type="number" placeholder="max(' + ma +
                ')"  max="' + ma + '" id="quantity" name="quantity">';


        });
    </script>
@endsection
