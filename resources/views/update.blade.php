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
                        <input type="hidden" name="myid" id="myid" value="">
                        @php
                            $url =route('user.update');
                        @endphp
                        @can('user-edit')
                        @php
                        $url =route('employee.update',['employee'=>$employee->id]);
                    @endphp
                        <div class="form-group">

                            <input type="text" name="name" id="name" aria-describedby="helpId"
                                placeholder="     Name" value="{{ $employee->name }}">
                            <span id="ename"></span>
                        </div>

                        <div class="form-group">

                            <select name="role" id="role" value="{{ $employee->user->getRoleNames()[0] }}">
                                <option value="2" @if ($employee->user->getRoleNames()[0] == 'Staff') {{ 'selected' }} @endif>Staff
                                </option>
                                <option value="1" @if ($employee->user->getRoleNames()[0] == 'Admin') {{ 'selected' }} @endif>Admin
                                </option>
                            </select>
                        </div>

                        <div class="form-group">

                            <input type="number" name="salary" id="salary" aria-describedby="helpId"
                                placeholder="    Salary" value="{{ $employee->salary }}">
                            <span id="esalary"></span>

                        </div>
                        <div class="form-group">

                            <input type="text" name="desigination" id="desigination" aria-describedby="helpId"
                                placeholder="    Desigination" value="{{ $employee->desigination }}">
                            <span id="edesigination"></span>

                        </div>
                        @endcan
                        <div class="form-group">

                            <input type="text" name="dob" id="dob" onfocus="(this.type='date')"
                                aria-describedby="helpId" placeholder="    DOB" value="{{ $employee->dob->format('Y-m-d') }}">
                            <span id="edob"></span>

                        </div>
                        <div class="form-group">

                            <input type="text" name="address" id="address" aria-describedby="helpId"
                                placeholder="    Address" value="{{ $employee->address }}">
                            <span id="eaddress"></span>
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
    <script>
        jQuery('#form').submit(function(e) {
            e.preventDefault();
            $("#eemail").text('');
            $("#ename").text('');
            $("#edesigination").text('');
            $("#esalary").text('');
            $("#edob").text('');
            $("#eaddress").text('');
            jQuery.ajax({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{$url}}",
                type: "PUT",
                data: jQuery('#form').serialize(),
                error: function(request, status, error) {
                    var go = request.responseText;
                    var goo = JSON.parse(go);
                    goo = goo.errors;
                    if (goo.name) {
                        document.getElementById("ename").innerHTML = goo.name[0];
                    }
                    if (goo.email) {
                        document.getElementById("eemail").innerHTML = goo.email[0];
                    }
                    if (goo.password) {
                        document.getElementById("epassword").innerHTML = goo.password[0];
                    }

                    if (goo.salary) {
                        document.getElementById("esalary").innerHTML = goo.salary[0];
                    }
                    if (goo.desigination) {
                        document.getElementById("edesigination").innerHTML = goo.desigination[0];
                    }
                    if (goo.dob) {
                        document.getElementById("edob").innerHTML = goo.dob[0];
                    }
                    if (goo.address) {
                        document.getElementById("eaddress").innerHTML = goo.address[0];
                    }

                },
                success: function(result) {
                    if (result == "") {
                        window.location = '/employee/{{ $employee->id }}';
                    } else {
                        $("#error").text(result);

                    }

                }
            });
        });
    </script>
@endsection
