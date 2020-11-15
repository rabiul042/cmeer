@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>{{ $title }}</li>
        </ul>
    </div>

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif


    <div class="row">
        <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>{{ $title }}
                        <a href="{{ url('admin/upload-result/'.$exam->id) }}"> <i class="fa fa-plus"></i> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><b>Exam Name:</b> {{ $exam->name }}</p>
                            <p><b>Course:</b> {{ $exam->course->name }}</p>
                            <p><b>Year:</b> {{ $exam->year }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><b>Session:</b> {{ $exam->sessions->name }}</p>
                            <p><b>Full Mark:</b> {{ $exam->question_type->full_mark }}</p>
                            <p><b>Highest Mark:</b> {{ $exam->highest_mark }}</p>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>Reg. No</th>
                            <th>Doctor Name</th>
                            <th>Batch</th>
                            <th>Discipline</th>
                            @if ($paper_faculty=='Paper')
                                <th>Paper</th>
                            @endif
                            @if($paper_faculty=='Faculty')
                                <th>Faculty</th>
                            @endif
                            @if($examination_code)
                                <th>Examination</th>
                            @endif
                            @if($candidate_code)
                                <th>Candidate</th>
                            @endif
                            <th>Obtained Mark</th>
                            <th>Overall Position</th>
                            <th>Discipline Position</th>
                            <th>Batch Position</th>
                            <th>Wrong Answer</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($doctor_courses as $doctor_course)
                            <tr>
                                <td>{{ $doctor_course->doctor_courses->reg_no }}</td>
                                <td>{{ $doctor_course->doctor_courses->doctor->name }}</td>
                                <td>{{ (isset($doctor_course->doctor_courses->batch->name))?$doctor_course->doctor_courses->batch->name:'' }}</td>
                                <td>{{ (isset($doctor_course->subject->name))?$doctor_course->subject->name:'' }}  </td>
                                @if ($paper_faculty=='Paper')
                                    <td>{{ (isset($doctor_course->paper_code)) ? $doctor_course->paper_code : '' }}</td>
                                @endif
                                @if($paper_faculty=='Faculty')
                                     <td>{{ (isset($doctor_course->faculty))? $doctor_course->faculty : '' }}</td>
                                @endif
                                @if($examination_code)
                                    <td>
                                        @if($doctor_course->examination_code=='A')
                                            Residency
                                        @elseif($doctor_course->examination_code=='B')
                                            M.Phil/Diploma
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endif
                                @if($candidate_code)
                                    <td>
                                        @if($doctor_course->candidate_code=='A')
                                            Gov't
                                        @elseif($doctor_course->candidate_code=='B')
                                            Private
                                        @elseif($doctor_course->candidate_code=='C')
                                            BSMMU
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $doctor_course->obtained_mark }}</td>
                                <td>{{ $doctor_course->possition }}</td>
                                <td>{{ $doctor_course->subject_possition }}</td>
                                <td>{{ $doctor_course->batch_possition }}</td>
                                <td>{{ $doctor_course->wrong_answers }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                "ordering": false,
                "columnDefs": [
                    { "searchable": false, "targets": 5 },
                    { "orderable": false, "targets": 5 }
                ]
            })
        })
    </script>

@endsection
