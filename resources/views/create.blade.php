
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


{{-- education start --}}

<div id="login_h">
    education 
</div>

<div id="rep">
    <div class="form-group">

        <select name="edu_level1" id="edu_level1">
            <option value="0">education level</option>
            <option value="0">HS</option>
            <option value="1">SHS</option>
            <option value="2">UG</option>
            <option value="3">PG</option>
        </select>
    </div>
    <div class="form-group">

        <input type="text" name="course_n1" id="course_n1" aria-describedby="helpId"
            placeholder="    Course(for ug & pg)">

    </div>
    <div class="form-group">

        <input type="text" name="place1" id="place1" aria-describedby="helpId"
            placeholder="    Board or University">

    </div>
    <div class="form-group">

        <input type="number" name="percent1" id="percent1" aria-describedby="helpId"
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

        <input type="text" name="name1" id="name1" aria-describedby="helpId"
            placeholder="    Member name">

    </div>
    <div class="form-group">

        <input type="number" name="age1" id="age1" aria-describedby="helpId"
            placeholder="    Member age">

    </div>
    <div class="form-group">

        <select name="relation1" id="relation1">
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

        <select name="employed1" id="employed1">
            <option value="0">employed</option>
            <option value="0">yes</option>
            <option value="1">no</option>
        </select>
    </div>
    <hr>
</div>
<div onclick="addq(this);" id="add"><p>ADD</p></div>
<input type="hidden" class="add" name="add" value=2>

{{--family add  --}}
                        
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
                function addq(value) {

opnum = $(value).attr('id');

append2 = '<div id="rep"><div class="form-group"><input type="text" name="name'+$('.' + opnum).attr('value')+'" id="name'+$('.' + opnum).attr('value')+'" aria-describedby="helpId" placeholder="    Member name"></div><div class="form-group"><input type="number" name="age'+$('.' + opnum).attr('value')+'" id="age'+$('.' + opnum).attr('value')+'" aria-describedby="helpId" placeholder="    Member age"></div><div class="form-group"><select name="relation'+$('.' + opnum).attr('value')+'" id="relation'+$('.' + opnum).attr('value')+'"><option value="mother">relation</option><option value="0">mother</option><option value="1">father</option><option value="2">sister</option><option value="3">brother</option><option value="4">whif/husbend</option><option value="5">son</option><option value="6">doughter</option></select></div><div class="form-group"><select name="employed'+$('.' + opnum).attr('value')+'" id="employed'+$('.' + opnum).attr('value')+'"><option value="0">employed</option><option value="0">yes</option><option value="1">no</option></select></div><hr></div> ';

$("#" + opnum).before(append2);
rqpnum = $("." + opnum).attr('value');
rqpnum = eval(rqpnum);
$("." + opnum).attr('value', rqpnum + 1);
}

function addq1(value) {

opnum = $(value).attr('id');

append2 = '<div id="rep"><div class="form-group"><select name="edu_level'+$('.' + opnum).attr('value')+'" id="edu_level'+$('.' + opnum).attr('value')+'"><option value="0">education level</option><option value="0">HS</option><option value="1">SHS</option><option value="2">UG</option><option value="3">PG</option></select></div><div class="form-group"><input type="text" name="course_n'+$('.' + opnum).attr('value')+'" id="course_n'+$('.' + opnum).attr('value')+'" aria-describedby="helpId" placeholder="    Course(for ug & pg)"></div><div class="form-group"><input type="text" name="place'+$('.' + opnum).attr('value')+'" id="place'+$('.' + opnum).attr('value')+'" aria-describedby="helpId" placeholder="    Board or University"></div><div class="form-group"><input type="number" name="percent'+$('.' + opnum).attr('value')+'" id="percent'+$('.' + opnum).attr('value')+'"aria-describedby="helpId" placeholder="    Percentage"></div><hr></div>';

$("#" + opnum).before(append2);
rqpnum = $("." + opnum).attr('value');
rqpnum = eval(rqpnum);
$("." + opnum).attr('value', rqpnum + 1);
}

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
                        // console.log(result);
                        $("#error").text(result);
                        
                    }
                   
                }
            });
        });
    </script>
@endsection




