@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">

            {{--@include('side_bar')--}}

            <div class="col-md-9 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>{{ isset($course_exam_result->doctor_course->course->name) ? $course_exam_result->doctor_course->course->name : '' }} Exam Result</h3></div>

                    <div class="panel-body">

                        @if(Session::has('message'))
                            <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-success' }}" role="alert">
                                <p> {{ Session::get('message') }}</p>
                            </div>
                        @endif

                        <div class="col-md-12 col-md-offset-0" style="">
                            <hr><h4><b>{{ isset($course_exam_result->exam->name) ? $course_exam_result->exam->name : '' }} Result</b></h4>
                        </div>

                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>course</th>
                                            <th>Exam</th>
                                            <th>Correct Mark</th>
                                            <th>Negative Mark</th>
                                            <th>Obtained Mark</th>
                                            <th>Wrong Answer</th>
                                            <th>Highest Mark</th>
                                            <th>Overall Position</th>
                                            <th>Batch Position</th>
                                            <th>Discipline Position</th>
                                            <th>View Answer</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--@foreach($course_exam_result as $course_exam_result)--}}
                                        <tr>
                                            <td>{{ isset($course_exam_result->id)?$course_exam_result->id:'' }}</td>
                                            <td>{{ isset($course_exam_result->doctor_course->course->name)?$course_exam_result->doctor_course->course->name:'' }}</td>
                                            <td>{{ isset($course_exam_result->exam->name)?$course_exam_result->exam->name:'' }}</td>
                                            <td>{{ isset($course_exam_result->correct_mark)?$course_exam_result->correct_mark:'' }}</td>
                                            <td>{{ isset($course_exam_result->negative_mark)?$course_exam_result->negative_mark:'' }}</td>
                                            <td>{{ isset($course_exam_result->obtained_mark)?$course_exam_result->obtained_mark:'' }}</td>
                                            <td>{{ isset($course_exam_result->wrong_answers)?$course_exam_result->wrong_answers:'' }}</td>
                                            <td>{{ isset($result['highest_mark'])?$result['highest_mark']:'' }}</td>
                                            <td>{{ isset($result['overall_position'])?$result['overall_position']:'' }}</td>
                                            <td>{{ isset($result['batch_position'])?$result['batch_position']:'' }}</td>
                                            <td>{{ isset($result['subject_position'])?$result['subject_position']:'' }}</td>
                                            <td>
                                                <a href="{{ url('course-exam-doctor-answer/'.$course_exam_result->doctor_course->id.'/'.$course_exam_result->exam->id) }}" class="btn btn-sm btn-primary">View Answers</a>
                                            </td>

                                        </tr>
                                        {{--@endforeach--}}
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