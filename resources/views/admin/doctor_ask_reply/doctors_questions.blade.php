@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <?php
            $urls='';
            foreach($breadcrumb as $key=>$value){ $urls .= $value.'/';
                echo '<li> <i class="fa fa-angle-right"></i> <a href="'.url('/').substr_replace($urls, "", -1).'">'.$value.'</a> </li>';
            }
            ?>
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
                        <i class="fa fa-globe"></i><?php echo $module_name;?> List
                    </div>
                </div>
                <div>
                    <div class="caption">

                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th width="100">#</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Doctor</th>
                            <th>Video</th>
                            <th width="140">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors_questions as $key => $doctor_question)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{(isset($doctor_question->doctor_course->course->name))?$doctor_question->doctor_course->course->name:''}}</td>
                                    <td>{{(isset($doctor_question->doctor_course->batch->name))?$doctor_question->doctor_course->batch->name:''}}</td>
                                    <td>
                                        {{(isset($doctor_question->doctor->name))?$doctor_question->doctor->name:'' }} 
                                        ({{(isset($doctor_question->doctor_course->reg_no))?$doctor_question->doctor_course->reg_no:''}})
                                    </td>
                                    <td>{{(isset($doctor_question->videoname->name))?$doctor_question->videoname->name:''}}</td>
                                    <td>
                                        <a href="view-conversation/{{$doctor_question->id}}" class="btn btn-xs btn-primary">View Conversation</a>
                                    </td>
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
                "columnDefs": [
                    { "searchable": false, "targets": 5 },
                    { "orderable": false, "targets": 5 }
                ]
            })
        })
    </script>

@endsection
