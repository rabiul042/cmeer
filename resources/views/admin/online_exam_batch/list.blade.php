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
                        @can('Lecture Video Batch')
                        <a href="{{url('admin/online-exam-batch/create')}}"> <i class="fa fa-plus"></i> </a>
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
                            <th>Year</th>
                            <th>Session</th>
                            <th>Branch</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($online_exam_batches as $online_exam_batch)
                            <tr>
                                <td>{{ $online_exam_batch->id }}</td>
                                <td>{{ $online_exam_batch->year }}</td>
                                <td>{{ $online_exam_batch->session->name }}</td>
                                <td>{{ $online_exam_batch->branch ? $online_exam_batch->branch->name : ''  }}</td>
                                <td>{{ $online_exam_batch->institute->name }}</td>
                                <td>{{ $online_exam_batch->course->name }}</td>
                                <td>{{ isset($online_exam_batch->batch->name)?$online_exam_batch->batch->name:'' }}</td>
                                <td>{{ ($online_exam_batch->status==1)?'Active':'InActive' }}</td>
                                <td>
                                    @can('Lecture Video Batch')
                                    <a href="{{ url('admin/online-exam-batch/'.$online_exam_batch->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Lecture Video Batch')
                                    {!! Form::open(array('route' => array('online-exam-batch.destroy', $online_exam_batch->id), 'method' => 'delete','style' => 'display:inline')) !!}
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