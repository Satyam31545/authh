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
    </style>
@endpush
@section('main-section')
    <div id="login_box">

        <div id="login">
            <div id="login_h">
                Create Product
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">

                            <input type="text" name="name" id="name" aria-describedby="helpId"
                                placeholder="     Name">
                            <span id="ename"></span>
                        </div>
                        <div class="form-group">

                            <input type="text" name="product_id" id="product_id" aria-describedby="helpId"
                                placeholder="     Product Id" value="{{ $id_code }}">
                            <span id="eproduct_id"></span>
                        </div>
                        <div class="form-group">

                            <input type="text" name="description" id="name" aria-describedby="helpId"
                                placeholder="     Description">
                            <span id="edescription"></span>
                        </div>
                        <div class="form-group">

                            <input type="number" name="prize" id="prize" aria-describedby="helpId"
                                placeholder="     prize">
                            <span id="eprize"></span>

                        </div>
                        <div class="form-group">

                            <input type="number" name="tax" id="prize" aria-describedby="helpId"
                                placeholder="     Tax">
                            <span id="etax"></span>

                        </div>
                        <div class="form-group">

                            <input type="number" name="quantity" id="quantity" aria-describedby="helpId"
                                placeholder="     quantity">
                            <span id="equantity"></span>

                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="REGISTER">
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
            $("#eprize").text('');
            $("#ename").text('');
            $("#eproduct_id").text('');
            $("#equantity").text('');
            $("#edescription").text('');
            $("#etax").text('');
            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{ url('/product') }}",
                type: "POST",
                data: jQuery('#form').serialize(),
                error: function(request, status, error) {
                    var go = request.responseText;
                    var goo = JSON.parse(go);
                    goo = goo.errors;


                    if (goo.name) {
                        document.getElementById("ename").innerHTML = goo.name[0];
                    }
                    if (goo.product_id) {
                        document.getElementById("eproduct_id").innerHTML = goo.product_id[0];
                    }
                    if (goo.quantity) {
                        document.getElementById("equantity").innerHTML = goo.quantity[0];
                    }
                    if (goo.prize) {
                        document.getElementById("eprize").innerHTML = goo.prize[0];
                    }
                    if (goo.description) {
                        document.getElementById("edescription").innerHTML = goo.description[0];
                    }
                    if (goo.tax) {
                        document.getElementById("etax").innerHTML = goo.tax[0];
                    }
                },
                success: function(result) {
                    if (result == "") {
                        window.location = '/product';
                    } else {
                        $("#error").text(result);
                    }

                }
            });
        });
    </script>
@endsection
