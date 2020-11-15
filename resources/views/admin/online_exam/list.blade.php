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
                        <a href="{{url('admin/online-exam/create')}}"> <i class="fa fa-plus"></i> </a>
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
                            <th>Exam Common Codes</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Topic</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($online_exams as $online_exam)
                            <tr>
                                <td>{{ $online_exam->id }}</td>
                                <td>{{ $online_exam->name }}</td>
                                <td>{{ $online_exam->exam_comm_code }}</td>
                                <td>{{ isset($online_exam->institute->name)?$online_exam->institute->name:'' }}</td>
                                <td>{{ isset($online_exam->course->name)?$online_exam->course->name:'' }}</td>
                                <td>{{ isset($online_exam->faculty->name)?$online_exam->faculty->name:'' }}</td>
                                <td>{{ isset($online_exam->topic->name)?$online_exam->topic->name:'' }}</td>
                                
                                <td>{{ ($online_exam->status==1)?'Active':'InActive' }}</td>
                                <td>
                                    @can('Lecture Video')
                                    <a href="{{ url('admin/online-exam/'.$online_exam->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Lecture Video')
                                    {!! Form::open(array('route' => array('online-exam.destroy', $online_exam->id), 'method' => 'delete','style' => 'display:inline')) !!}
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
                    { "searchable": false, "targets": 8 },
                    { "orderable": false, "targets": 8 }
                ]
            })
        })
    </script>

@endsection
