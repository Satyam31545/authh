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
                            $url = route('user.update');
                        @endphp
                        @can('user-edit')
                            @php
                                $url = route('employee.update', ['employee' => $employee->id]);
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
                                aria-describedby="helpId" placeholder="    DOB" value="{{ $employee->dob }}">
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
                url: "{{ $url }}",
                type: "PUT",
                data: jQuery('#form').serialize(),
                error: function(response, status, error) {

                    if (response.status == 422) {
                        var validationError = JSON.parse(response.responseText).errors;
                        if (validationError.name) {
                            document.getElementById("ename").innerHTML = validationError.name[0];
                        }
                        if (validationError.email) {
                            document.getElementById("eemail").innerHTML = validationError.email[0];
                        }
                        if (validationError.password) {
                            document.getElementById("epassword").innerHTML = validationError.password[
                            0];
                        }

                        if (validationError.salary) {
                            document.getElementById("esalary").innerHTML = validationError.salary[0];
                        }
                        if (validationError.desigination) {
                            document.getElementById("edesigination").innerHTML = validationError
                                .desigination[0];
                        }
                        if (validationError.dob) {
                            document.getElementById("edob").innerHTML = validationError.dob[0];
                        }
                        if (validationError.address) {
                            document.getElementById("eaddress").innerHTML = validationError.address[0];
                        }


                    } else if (response.status == 400) {
                        $("#error").text(JSON.parse(response.responseText).error);
                    }

                },
                success: function(result) {
                        window.location = '/employee/{{ $employee->id }}';
                }
            });
        });
    </script>
@endsection
