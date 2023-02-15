@extends('layouts.main')

@push('title')
    <title>EMS | Family</title>
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
                Add family
            </div>

            <div id="form_container">
                <div id="forms">
                    <form id="form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <input type="hidden" name="emp_id" id="emp_id" value="{{ $id }}">

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
                        <div onclick="addq(this);" id="add">
                            <p>ADD</p>
                        </div>
                        <input type="hidden" class="add" name="add" value=2>
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
        function addq(value) {

            opnum = $(value).attr('id');

            append2 = '<div id="rep"><div class="form-group"><input type="text" name="name' + $('.' + opnum).attr('value') +
                '" id="name' + $('.' + opnum).attr('value') +
                '" aria-describedby="helpId" placeholder="    Member name"></div><div class="form-group"><input type="number" name="age' +
                $('.' + opnum).attr('value') + '" id="age' + $('.' + opnum).attr('value') +
                '" aria-describedby="helpId" placeholder="    Member age"></div><div class="form-group"><select name="relation' +
                $('.' + opnum).attr('value') + '" id="relation' + $('.' + opnum).attr('value') +
                '"><option value="0">mother</option><option value="1">father</option><option value="2">sister</option><option value="3">brother</option><option value="4">whif/husbend</option><option value="5">son</option><option value="6">doughter</option></select></div><div class="form-group"><select name="employed' +
                $('.' + opnum).attr('value') + '" id="employed' + $('.' + opnum).attr('value') +
                '"><option value="0">yes</option><option value="1">no</option></select></div><hr></div> ';

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
                url: "{{ url('/family') }}/{{ $id }}",
                type: "POST",
                data: jQuery('#form').serialize(),
                success: function(result) {
                    if (result == "") {
                        window.location = '/employee/{{ $id }}';
                    } else {
                        // console.log(result);
                        $("#error").text(result);

                    }
                }
            });
        });
    </script>
@endsection
