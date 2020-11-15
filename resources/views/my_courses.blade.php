@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>My Courses</h3></div>

                <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <?php if (isset($_GET['msgs'])) { echo "<div class='alert alert-success'>{$_GET['msgs']}</div>"; } ?>
                        <?php if (isset($_GET['msgf'])) { echo "<div class='alert alert-success' style='color:red;'>{$_GET['msgf']}</div>"; } ?>
                        <?php if (isset($_GET['msgc'])) { echo "<div class='alert alert-success' style='color:red;'>{$_GET['msgc']}</div>"; } ?>



                        <div class="col-md-12 col-md-offset-0" style="">
                            <hr><h4><b>My Courses</b></h4>
                        </div>

                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
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
                                            @foreach ($doc_info->doctorcourses as $k=>$value)
                                            @if($value->is_trash == '0')
                                            <tr>
                                                <td>{{ $k+1 }}</td>
                                                <td>{{ $value['reg_no'] }}</td>
                                                <td>{{ $value['year'] }}</td>
                                                <td>{{ (isset($value->session->name))?$value->session->name:'' }}</td>
                                                <td>{{ (isset($value->course->name))?$value->course->name:'' }}</td>
                                                <td>{{ (isset($value->subject->name))?$value->subject->name:'' }}</td>
                                                <td>{{ (isset($value->batch->name))?$value->batch->name:'' }}</td>
                                                <td>
                                                    @if(!$value->is_discipline_changed)
                                                        <a href="{{ url('my-courses/edit-doctor-course-discipline/'.$value->id) }}" target="_blank" class="btn btn-xs btn-info">Change Discipline</a>
                                                    @endif
                                                    <a href="{{ url('doc-profile/view-course-result/'.$value->id) }}" target="_blank" class="btn btn-xs btn-primary">Result</a>
                                                    @if($doc_info->schedule_id)
                                                        <a href="{{ url("doc-profile/print-batch-schedule/".$doc_info->schedule_id) }}" class='btn btn-xs btn-primary' target='_blank'>Schedule</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
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
