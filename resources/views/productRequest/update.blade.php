@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
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

        #status {
            height: 22px;
            /* width: 250px; */
            border: 0px solid black;
            font-size: 15px;
            box-shadow: 0px 0px 0px #888888;
            width: 22px;
        }

        #statusbox {
            display: block;
        }

        label {
            font-size: 25px;
        }
    </style>
@endpush
@section('main-section')
    <div id="login_box">

        <div id="login">
            <div id="login_h">
                Assign Product
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @forelse ($productRequest->requestedProducts as $requestedProduct)
                            <div class="form-group">
                                product name: {{ $requestedProduct->product->id }}
                            </div>
                            <div class="form-group">
                                required quantity: {{ $requestedProduct->quantity }}
                            </div>
                            <div class="form-group">

                                <input type="number" name="quantity[]" id="quantity" aria-describedby="helpId"
                                    placeholder="     quantity"
                                    max="{{ min($requestedProduct->product->quantity, $requestedProduct->quantity) }}"
                                    value="0">
                                <span id="equantity[]"></span>

                            </div>

                            <hr>
                            @empty 
                            no data found
                        @endforelse
                        <div class="statusbox">
                            <label for="status">Inactivate</label>
                            <input type="checkbox" name="status" id="status" aria-describedby="helpId" value="1">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="REQUEST">
                        </div>
                    </form>
                    <div id="error"></div>
                </div>

            </div>
        </div>
    </div>
    <script src="http://127.0.0.1:8000/jquary.js"></script>
    <script>
        jQuery('#form').submit(function(e) {
            e.preventDefault();
            $("#equantity").text('');
            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{ url('/productRequest') }}/{{ $productRequest->id }}",
                type: "PUT",
                data: jQuery('#form').serialize(),
                error: function(response, status, error) {
                    if (response.status == 422) {
                        var validationError = JSON.parse(response.responseText).errors;
                        $("#error").text("all the quantity feild must be filled");
                    } else if (response.status == 400) {
                        $("#error").text(JSON.parse(response.responseText).error);
                    }

                },
                success: function() {
                    window.location = '/productRequest';
                }
            });
        });
    </script>
@endsection
