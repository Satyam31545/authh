@extends('layouts.main')

@push('title')
    <title>EMS | Update</title>
    <style>
        body {
            background-color: #df9ef5;
            margin: 0px;

        }


        #login {
            height: 700px;
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
        .lock{
            display: block;
        }
        .lock>input{
            box-shadow: 0px 0px 0px #ffffff;
            height: 15px;
            width:  20px;
        }
    </style>
@endpush
@section('main-section')
    <div id="login_box">

        <div id="login">
 

            <div id="login_h">
               update role
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">

                            @foreach($permission as $value)
                           <div class="lock">{{ $value->name }}
                           {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                            
                        <br/></div>
                        @endforeach
                        
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
    <script src="http://127.0.0.1:8000/jquary.js"></script>
    <script>
        jQuery('#form').submit(function(e) {
            e.preventDefault();
            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{url('Role_update')}}",
                type: "POST",
                data: jQuery('#form').serialize(),
                success: function(result) {
                    if (result =="") {
                         window.location = '/employee';
                    }else{
                        // console.log(result);
                        $("#error").text(result);

                    }
                   
                }
            });
        });

    </script>
@endsection
