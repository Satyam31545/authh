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
                                <option value="2">Staff</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">

                            <input type="number" name="salary" id="salary" aria-describedby="helpId"
                                placeholder="    Salary">
                            <span id="esalary"></span>

                        </div>
                        <div class="form-group">

                            <input type="text" name="desigination" id="desigination"
                                aria-describedby="helpId" placeholder="    Desigination">
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


                        {{-- education start --}}

                        <div id="login_h">
                            education
                        </div>

                        <div id="rep">
                            <div class="form-group">

                                <select name="education[0][edu_level]" id="edu_level1">
                                    <option value="0">education level</option>
                                    <option value="0">HS</option>
                                    <option value="1">SHS</option>
                                    <option value="2">UG</option>
                                    <option value="3">PG</option>
                                </select>
                            </div>
                            <div class="form-group">

                                <input type="text" name="education[0][course_n]" id="course_n1" aria-describedby="helpId"
                                    placeholder="    Course(for ug & pg)">

                            </div>
                            <div class="form-group">

                                <input type="text" name="education[0][place]" id="place1" aria-describedby="helpId"
                                    placeholder="    Board or University">

                            </div>
                            <div class="form-group">

                                <input type="number" name="education[0][percent]" id="percent1" aria-describedby="helpId"
                                    placeholder="    Percentage">

                            </div>
                            <hr>
                        </div>
                        <div onclick="addq1(this);" id="add1">
                            <p>ADD</p>
                        </div>
                        <input type="hidden" class="add1" name="add1" value=2>
                        {{--  education ed --}}


                        {{-- family add --}}

                        <div id="login_h">
                            family
                        </div>
                        <div id="rep">
                            <div class="form-group">

                                <input type="text" name="family[0][name]" id="name1" aria-describedby="helpId"
                                    placeholder="    Member name">

                            </div>
                            <div class="form-group">

                                <input type="number" name="family[0][age]" id="age1" aria-describedby="helpId"
                                    placeholder="    Member age">

                            </div>
                            <div class="form-group">

                                <select name="family[0][relation]" id="relation1">
                                    <option value="mother">relation</option>
                                    <option value="mother">mother</option>
                                    <option value="father">father</option>
                                    <option value="whif">whif</option>
                                    <option value="brother">brother</option>
                                    <option value="husbend">husbend</option>
                                    <option value="son">son</option>
                                    <option value="daughter">daughter</option>
                                </select>
                            </div>
                            <div class="form-group">

                                <select name="family[0][employed]" id="employed1">
                                    <option value="0">employed</option>
                                    <option value="0">yes</option>
                                    <option value="1">no</option>
                                </select>
                            </div>
                            <hr>
                        </div>
                        <div onclick="addq(this);" id="add">
                            <p>ADD</p>
                        </div>
                        <input type="hidden" class="add" name="add" value=2>

                        {{-- family add  --}}

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
        var family =1;
        var education =1;
        function addq(value) {

            opnum = $(value).attr('id');

            append2 = '<div id="rep"><div class="form-group"><input type="text" name="family['+family+'][name]" id="name" aria-describedby="helpId" placeholder="    Member name"></div><div class="form-group"><input type="number" name="family['+family+'][age]" id="age" aria-describedby="helpId" placeholder="    Member age"></div><div class="form-group"><select name="family['+family+'][relation]" id="relation"><option value="mother">relation</option><option value="mother">mother</option><option value="father">father</option><option value="sister">sister</option><option value="brother">brother</option><option value="whif">whif/husbend</option><option value="son">son</option><option value="6">doughter</option></select></div><div class="form-group"><select name="family['+family+'][employed]" id="employed"><option value="0">employed</option><option value="0">yes</option><option value="1">no</option></select></div><hr></div> ';

            $("#" + opnum).before(append2);
            rqpnum = $("." + opnum).attr('value');
            rqpnum = eval(rqpnum);
            $("." + opnum).attr('value', rqpnum + 1);
            family++;
        }

        function addq1(value) {

            opnum = $(value).attr('id');

            append2 = '<div id="rep"><div class="form-group"><select name="education['+education+'][edu_level]" id="edu_level"><option value="0">education level</option><option value="0">HS</option><option value="1">SHS</option><option value="2">UG</option><option value="3">PG</option></select></div><div class="form-group"><input type="text" name="education['+education+'][course_n]" id="course_n" aria-describedby="helpId" placeholder="    Course(for ug & pg)"></div><div class="form-group"><input type="text" name="education['+education+'][place]" id="place" aria-describedby="helpId" placeholder="    Board or University"></div><div class="form-group"><input type="number" name="education['+education+'][percent]" id="percent"aria-describedby="helpId" placeholder="    Percentage"></div><hr></div>';

            $("#" + opnum).before(append2);
            rqpnum = $("." + opnum).attr('value');
            rqpnum = eval(rqpnum);
            $("." + opnum).attr('value', rqpnum + 1);
            education++;
        }

        jQuery('#form').submit(function(e) {
            e.preventDefault();
            $("#eemail").text('');
            $("#ename").text('');
            $("#epassword").text('');
            $("#edesigination").text('');
            $("#esalary").text('');
            $("#edob").text('');
            $("#eaddress").text('');
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
                        window.location = '/employee';
                    } else {
                        // $("#error").text(result);
                        console.log(result);

                    }

                }
            });
        });
    </script>
@endsection
