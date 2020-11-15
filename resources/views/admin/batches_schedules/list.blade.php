@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>Batches Schedules List</li>
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
                        <i class="fa fa-globe"></i>Batches Schedules List
                    </div>
                </div>
                <div>
                    <?php
                    //echo '<pre>';
                    //print_r($doctors);
                    ?>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Session</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Schedule Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=1;
                        @endphp

                        @foreach($batches_schedules as $batch_schedule)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ isset($batch_schedule->name) ? $batch_schedule->name : '' }}</td>
                                <td>{{ isset($batch_schedule->year) ? $batch_schedule->year : '' }}</td>
                                <td>{{ isset($batch_schedule->session->name) ? $batch_schedule->session->name : '' }}</td>
                                {{--<td>{{ isset($batch_schedule->institute_id) ? $batch_schedule->institute->name : '' }}</td>--}}
                                <td>{{ isset($batch_schedule->course->name) ? $batch_schedule->course->name : '' }}</td>
                                <td>{{ isset($batch_schedule->batch->name) ? $batch_schedule->batch->name : '' }}</td>
                                <td>{{ isset($batch_schedule->service_packages->name) ? $batch_schedule->service_packages->name : '' }}</td>
                                <td>{{ ($batch_schedule->status==1)?'Active':'InActive' }}</td>
                                <td>
                                    @can('Batch Schedule Print')
                                    <a  target="_blank" href="{{ url('admin/batches-schedules/print-batch-schedule/'.$batch_schedule->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Print</a>
                                    @endcan
                                    @can('Batch Schedule Edit')
                                    <a href="{{ url('admin/batches-schedules/'.$batch_schedule->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Batch Schedule Delete')
                                        {!! Form::open(array('route' => array('batches-schedules.destroy', $batch_schedule->id), 'method' => 'delete','style' => 'display:inline')) !!}
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