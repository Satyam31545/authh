@extends('layouts.main')

@push('title')
    <title>EMS | Create</title>
    <style>
        body {
            background-color: #df9ef5;
            margin: 0px;

        }

        #login {
            height: auto;
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

        #hiddenProduct {
            display: none;
        }
    </style>
@endpush
@section('main-section')
    <div id="login_box">

        <div id="login">
            <div id="login_h">
                Create Request
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input type="text" name="request_id" id="request_id" aria-describedby="helpId"
                                placeholder="    Request Id" value="{{ $id_code }}">
                            <span id="erequest_id"></span>
                        </div>

                        <div class="form-group">
                            <input type="text" name="due_date" id="due_date" onfocus="(this.type='date')"
                                aria-describedby="helpId" placeholder="    Due date">
                            <span id="edue_date"></span>
                        </div>

                        <div class="form-group">
                            <input type="text" name="remark" id="remark" aria-describedby="helpId"
                                placeholder="     Remark">
                            <span id="eremark"></span>
                        </div>

                        {{-- education start --}}

                        <div id="login_h">
                            Products
                        </div>

                        <div id="rep">
                            <div class="form-group">

                                <select name="product_request[0][product_id]" id="product">
                                    <option value="0">product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">

                                <input type="number" name="product_request[0][quantity]" id="quantity"
                                    aria-describedby="helpId" placeholder="    Quantity">

                            </div>
                            <hr>
                        </div>
                        <div onclick="addq1(this);" id="add1">
                            <p>ADD</p>
                        </div>
                        <input type="hidden" class="add1" name="add1" value=2>
                        {{--  education ed --}}

                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="REGISTER">
                        </div>
                        <div id="error"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="hiddenProduct">
        <div id="rep">
            <div class="form-group">

                <select name="product_request[][product_id]" id="product">
                    <option value="0">product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">

                <input type="number" name="product_request[][quantity]" id="quantity" aria-describedby="helpId"
                    placeholder="    Quantity">

            </div>

        </div>
    </div>
    <script src="http://127.0.0.1:8000/jquary.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  --}}
    <script>
        var num = 1;

        function addq1(value) {
            document.getElementById("hiddenProduct").firstElementChild.firstElementChild.firstElementChild.name =
                "product_request[" + num + "][product_id]";
            document.getElementById("hiddenProduct").firstElementChild.lastElementChild.firstElementChild.name =
                "product_request[" + num + "][quantity]";
            num++;
            opnum = $(value).attr('id');
            $("#" + opnum).before(document.getElementById("hiddenProduct").innerHTML);
            $("#" + opnum).before("<hr>");
        }

        jQuery('#form').submit(function(e) {
            e.preventDefault();
            $("#erequest_id").text('');
            $("#edue_date").text('');
            $("#eremark").text('');

            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{ url('/productRequest') }}",
                type: "POST",
                data: jQuery('#form').serialize(),
                error: function(response, status, error) {


                    if (response.status == 422) {
                        var validationError = JSON.parse(response.responseText).errors;
                        if (validationError.request_id) {
                            document.getElementById("erequest_id").innerHTML = validationError
                                .request_id[0];
                        }
                        if (validationError.due_date) {
                            document.getElementById("edue_date").innerHTML = validationError.due_date[
                            0];
                        }
                        if (validationError.remark) {
                            document.getElementById("eremark").innerHTML = validationError.remark[0];
                        }
                    } else if (response.status == 400) {
                        $("#error").text(JSON.parse(response.responseText).error);
                    }

                },
                success: function(result) {
                    window.location = '/myproduct';
                }
            });
        });
    </script>
@endsection
