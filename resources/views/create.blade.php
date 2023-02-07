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
                Create User
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

                            <input type="email" name="email" id="email" aria-describedby="helpId"
                                placeholder="     Email">
                            <span id="eemail"></span>

                        </div>
                        <div class="form-group">

                            <input type="password" name="password" id="password" aria-describedby="helpId"
                                placeholder="    Password">
                            <span id="epassword"></span>

                        </div>
                        <div class="form-group">

                            <select name="role" id="role">
                                <option value="0">Staff</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">

                            <input type="number" name="salary" id="salary" aria-describedby="helpId"
                                placeholder="    Salary">
                            <span id="esalary"></span>

                        </div>
                        <div class="form-group">

                            <input type="text" name="desigination" id="desigination" aria-describedby="helpId"
                                placeholder="    Desigination">
                            <span id="edesigination"></span>

                        </div>
                        <div class="form-group">

                            <input type="text" name="dob" id="dob" onfocus="(this.type='date')"
                                aria-describedby="helpId" placeholder="    DOB">
                            <span id="edob"></span>

                        </div>
                        <div class="form-group">

                            <input type="text" name="address" id="address" aria-describedby="helpId"
                                placeholder="    Address">
                            <span id="eaddress"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="REGISTER">
                        </div>
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
                url: "{{ url('/employee') }}",
                type: "POST",
                data: jQuery('#form').serialize(),
                error: function(request, status, error) {
                    var go = request.responseText;
                    var goo = JSON.parse(go);
                    goo = goo.errors;
                    if (goo) {
                        document.getElementById("login").style.height = "700px";
                    }

                    document.getElementById("eemail").innerHTML = goo.email[0];
                    document.getElementById("epassword").innerHTML = goo.password[0];
                    document.getElementById("ename").innerHTML = goo.name[0];
                    document.getElementById("esalary").innerHTML = goo.salary[0];
                    document.getElementById("edesigination").innerHTML = goo.desigination[0];
                    document.getElementById("edob").innerHTML = goo.dob[0];
                    document.getElementById("eaddress").innerHTML = goo.address[0];

                },
                success: function(result) {
                    if (result =="") {
                         window.location = '/employee';
                    }else{
                        console.log(result);
                    }
                   
                }
            });
        });
    </script>
@endsection
