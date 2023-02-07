@extends('layouts.main')

@push('title')
    <title>EMS | Education</title>
    <style>
        #login {
            height: 100%;
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

        #add {
            text-align: center;
        }
    </style>
@endpush
@section('main-section')
    <div id="login_box">

        <div id="login">
            <div id="login_h">
                Add education
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="emp_id" id="emp_id" value="{{$id}}">

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
                        <div onclick="addq(this);" id="add">
                            <p>ADD</p>
                        </div>
                        <input type="hidden" class="add" name="add" value=2>
                        <div class="form-group">
                            <input type="submit" name="submit" id="send" value="REGISTER">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="http://127.0.0.1:8000/jquary.js"></script>

    <script>
        function addq(value) {

            opnum = $(value).attr('id');

            append2 = '<div id="rep"><div class="form-group"><select name="edu_level'+$('.' + opnum).attr('value')+'" id="edu_level'+$('.' + opnum).attr('value')+'"><option value="0">relation</option><option value="0">HS</option><option value="1">SHS</option><option value="2">UG</option><option value="3">PG</option></select></div><div class="form-group"><input type="text" name="course_n'+$('.' + opnum).attr('value')+'" id="course_n'+$('.' + opnum).attr('value')+'" aria-describedby="helpId" placeholder="    Course(for ug & pg)"></div><div class="form-group"><input type="text" name="place'+$('.' + opnum).attr('value')+'" id="place'+$('.' + opnum).attr('value')+'" aria-describedby="helpId" placeholder="    Board or University"></div><div class="form-group"><input type="number" name="percent'+$('.' + opnum).attr('value')+'" id="percent'+$('.' + opnum).attr('value')+'"aria-describedby="helpId" placeholder="    Percentage"></div><hr></div>';

            $("#" + opnum).before(append2);
            rqpnum = $("." + opnum).attr('value');
            rqpnum = eval(rqpnum);
            $("." + opnum).attr('value', rqpnum + 1);
        }
        // ajax

        $('#form').submit(function(e) {
            e.preventDefault();
            $.ajax({

                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                },
                url: "{{ url('/education')}}/{{$id}}",
                type: "POST",
                data: jQuery('#form').serialize(),
                success: function(result) {
                    if (result =="") {
                         window.location = '/employee/{{$id}}';
                    }else{
                        console.log(result);
                    }
                }
            });
        });
    </script>
@endsection
