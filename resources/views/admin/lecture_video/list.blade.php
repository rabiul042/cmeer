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
                        @can('Lecture Video')
                        <a href="{{url('admin/lecture-video/create')}}"> <i class="fa fa-plus"></i> </a>
                        @endcan
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Video Address</th>
                            <th>Video Password</th>
                            <th>Video PDF</th>
                            <!-- <th>Download Doctor Emails</th> -->
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Class/Chapter</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($lecture_videos as $lecture_video)
                            <tr>
                                <td>{{ $lecture_video->id }}</td>
                                <td>{{ $lecture_video->name }}</td>
                                <td>{{ $lecture_video->lecture_address }}</td>
                                <td>{{ $lecture_video->password }}</td>
                                <td><a target="_blank" href="http://127.0.0.1:8000/pdf/{{$lecture_video->pdf_file}}">{{ $lecture_video->pdf_file }}</a></td>
                                <!-- <td><a href="{{ url('admin/download-lecture-related-emails/'.$lecture_video->id) }}" class="btn btn-xs btn-primary" target="_blank">Download Doctors Emails</a></td> -->
                                <td>{{ isset($lecture_video->institute->name)?$lecture_video->institute->name:'' }}</td>
                                <td>{{ isset($lecture_video->course->name)?$lecture_video->course->name:'' }}</td>
                                <td>{{ isset($lecture_video->faculty->name)?$lecture_video->faculty->name:'' }}</td>
                                
                                <td>{{ isset($lecture_video->topic->name)?$lecture_video->topic->name:'' }}</td>
                                <td>{{ ($lecture_video->status==1)?'Active':'InActive' }}</td>
                                <td>
                                    @can('Lecture Video')
                                    <a href="{{ url('admin/lecture-video/'.$lecture_video->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Lecture Video')
                                    {!! Form::open(array('route' => array('lecture-video.destroy', $lecture_video->id), 'method' => 'delete','style' => 'display:inline')) !!}
                                    <button onclick="return confirm('Are You Sure ?')" class='btn btn-xs btn-danger' type="submit">Delete</button>
                                    {!! Form::close() !!}
                                    @endcan
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
                    { "searchable": false, "targets": 9 },
                    { "orderable": false, "targets": 9 }
                ]
            })
        })
    </script>

@endsection
