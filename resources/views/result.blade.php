@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Result</h3></div>

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
                                            <th>Course</th>
                                            <th>Discipline</th>
                                            <th>Batch</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        @foreach ($course_info as $sl => $value)
                                        
                                        <tr>
                                            <td>{{ $sl+1 }}</td>
                                            <td>{{ $value['reg_no'] }}</td>
                                            <td>{{ $value['year'] }}</td>
                                            <td>{{ (isset($value->session->name))?$value->session->name:'' }}</td>
                                            <td>{{ (isset($value->course->name))?$value->course->name:'' }}</td>
                                            <td>{{ (isset($value->subject->name))?$value->subject->name:'' }}</td>
                                            <td>{{ (isset($value->batch->name))?$value->batch->name:'' }}</td>
                                            <td>
                                                <a href="{{ url('doc-profile/view-course-result/'.$value->id) }}" target="_blank" class="btn btn-xs btn-primary">Result</a>
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
