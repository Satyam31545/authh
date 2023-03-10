@extends('layouts.main')

@push('title')
    <title>EMS | View</title>
    <style>
        #login_box,
        #persional,
        #educational,
        #experience,
        #family {
            display: grid;
        }

        #detail {
            padding-left: 25px;


        }

        #allhead {
            text-align: center;
            font-size: 30px;
            color: red;
        }
    </style>
@endpush
@section('main-section')
    @php
        $arr = ['HS', 'SHS', 'UG', 'PG'];
        $arr2 = ['NO', 'YES'];
       
    @endphp
    <div id="detail">
        <div id="persional">
            <div id="allhead">Persional</div>
            <p>id - {{ $user->employees->id }}</p>
            <p>name - {{ $user->employees->name }}</p>
            <p>role - {{ $user->getRoleNames()[0] }}</p>
            <p>salary - {{ $user->employees->salary }}</p>
            <p>desigination - {{ $user->employees->desigination }}</p>
            <p>dob - {{ $user->employees->dob }}</p>
            <p>address - {{ $user->employees->address }}</p>
        </div>

        <div id="educational">
            <div id="allhead">educational</div>
            @php
                $i = 1;
                foreach ($user->employees->education as $edu) {
                    $i += 1;
                    $edudi =
                        '<div id="edudiv">
        <p>educational level - ' .
                        $arr[$edu->edu_level] .
                        '</p>
        <p>course - ' .
                        $edu->course_n .
                        '</p>
        <p>board or university-' .
                        $edu->place .
                        '</p>
        <p>Percentag - ' .
                        $edu->percent .
                        '</p>
        <hr>
        </div>';
                    echo $edudi;
                }
                if ($i == 1) {
                    echo 'No educational data found';
                }
            @endphp
        </div>

        <div id="family">
            <div id="allhead">family</div>
            @php
                $i = 1;
                foreach ($user->employees->families as $fam) {
                    $i += 1;
                    $famui =
                        '<div id="expdiv">
                <p>Name - ' .
                        $fam->name .
                        '</p>
                <p>Relation - ' .
                        $fam->relation .
                        '</p>
                <p>Age-' .
                        $fam->age .
                        '</p>
                <p>Employeed - ' .
                        $arr2[$fam->employeed] .
                        '</p>
                <hr>
                </div>';
                    echo $famui;
                }
                if ($i == 1) {
                    echo 'No educational data found';
                }
            @endphp
        </div>
    </div>

    </div>
    <script src="http://127.0.0.1:8000/jquary.js"></script>

    <script></script>
@endsection
