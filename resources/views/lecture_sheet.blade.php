@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Lecture Sheet</h3></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <h4><b>Course List </b></h4>
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Reg. No.</th>
                                            <th>Year</th>
                                            <th>Session</th>
                                            <th>Institute</th>
                                            <th>Course</th>
                                            <th>Discipline</th>
                                            <th>Batch</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($doctor_courses as $key=>$doctor_course)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $doctor_course->reg_no }}</td>
                                            <td>{{ $doctor_course->year }}</td>
                                            <td>
                                               {{ isset($doctor_course->session_id)?$doctor_course->session->name:''}}
                                            </td>
                                            <td>
                                               {{ isset($doctor_course->institute_id)?$doctor_course->institute->name:''}}
                                            </td>
                                            <td>
                                                {{ isset($doctor_course->course_id)?$doctor_course->course->name:''}}
                                            </td>
                                            <td>
                                                {{ isset($doctor_course->subject->name)?$doctor_course->subject->name:''}}
                                            </td>
                                            <td>
                                                {{ isset($doctor_course->batch->name)?$doctor_course->batch->name:''}}
                                            </td>
                                            <td>
                                                <a href="{{ url('lecture-topics/'.$doctor_course->id) }}" class="btn btn-xs btn-primary">Lecture Sheet</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>

    </div>


</div>
@endsection
