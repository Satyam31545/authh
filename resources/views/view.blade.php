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
    <div id="detail">
        <div id="persional">
            <div id="allhead">Personal</div>
            <p>id - {{ $employee->id }}</p>
            <p>name - {{ $employee->name }}</p>
            <p>role - {{ $employee->user->getRoleNames()[0] }}</p>
            <p>salary - {{ $employee->salary }}</p>
            <p>desigination - {{ $employee->desigination }}</p>
            <p>dob - {{ $employee->dob->format('d-m-Y') }}</p>
            <p>address - {{ $employee->address }}</p>
        </div>

        <div id="educational">
            <div id="allhead">Education Details</div>
            @forelse ($employee->education as $edu)
                <div id="edudiv">
                    <p>educational level - {{ $edu->edu_level }}</p>
                    <p>course - {{ $edu->course_n }}</p>
                    <p>board or university - {{ $edu->place }}</p>
                    <p>Percentag - {{ $edu->percent }}</p>
                    <hr>
                </div>
            @empty
                <p>No Educational Details Found.</p>
            @endforelse
        </div>

        <div id="family">
            <div id="allhead">family Details</div>
            @forelse ($employee->families as $fam)
                <div id="expdiv">
                    <p>Name - {{ $fam->name }}</p>
                    <p>Relation - {{ $fam->relation }}</p>
                    <p>Age - {{ $fam->age }}</p>
                    <p>Employeed - {{ $fam->employeed }}</p>
                    <hr>
                </div>
            @empty
                <p>No Educational Details Found.</p>
            @endforelse
        </div>
    </div>

    <script src="http://127.0.0.1:8000/jquary.js"></script>

    <script></script>
@endsection
