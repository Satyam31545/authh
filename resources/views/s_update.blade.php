@extends('layouts.main')

@push('title')
    <title>EMS | Update</title>
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
                Update User
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>DOB</label>
                            <input type="text" name="dob" id="dob" onfocus="(this.type='date')"
                                aria-describedby="helpId" placeholder="    DOB" value="{{ $emp[0]->dob }}">
                            <span id="edob"></span>

                        </div>
                        <div class="form-group">
                            <label>Address</label>

                            <input type="text" name="address" id="address" aria-describedby="helpId"
                                placeholder="    Address" value="{{ $emp[0]->address }}">
                            <span id="eaddress"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="Update">
                        </div>
                        <div id="error"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="jquary.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  --}}
    <script>
        jQuery('#form').submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{ url('/update') }}",
                type: "PUT",
                data: jQuery('#form').serialize(),
                success: function(result) {
                    if (result == "") {
                        window.location = '/home';
                    } else {
                        $("#error").text(result);
                    }
                }
            });
        });
    </script>
@endsection
