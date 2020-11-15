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
                        <a href="{{ action('Admin\BatchController@create') }}"> <i class="fa fa-plus"></i> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Batch Name</th>
                            <th>Batch Code</th>
                            <th>Start Index</th>
                            <th>End Index</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Branch</th>
                            {{--<th>Faculty</th>--}}
                            <th>Discipline</th>
                            <th>Admission Fee</th> 
                            <th>Fee For</th>
                            <th>Payment Times</th>
                            <th>Minimum Pay (%)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($batches as $batch)
                        
                            <tr>
                                <td>{{ $batch->id }}</td>
                                <td>{{ $batch->name }}</td>
                                <td>{{ $batch->batch_code }}</td>
                                <td>{{ $batch->start_index }}</td>
                                <td>{{ $batch->end_index }}</td>
                                <td>{{ (isset($batch->institute->name))?$batch->institute->name:'' }}</td>
                                <td>{{ (isset($batch->course->name))?$batch->course->name:'' }}</td>
                                <td>{{ (isset($batch->branch->name))?$batch->branch->name:'' }}</td>
                                {{--<td>{{ (isset($batch->faculty->name))?$batch->faculty->name:'' }}</td>--}}
                                <td>{{ (isset($batch->subject->name))?$batch->subject->name:'' }}</td>
                                <td>{{ $batch->admission_fee }}</td>
                                <td>{{ $batch->fee_type }}</td>
                                <td>{{ $batch->payment_times }}</td>
                                <td>{{ $batch->minimum_payment }}%</td>
                                <td>{{ ($batch->status == 1)? 'Active':'InActive' }}</td>


                                <td>
                                    <a href="{{ url('admin/batch/'.$batch->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    {!! Form::open(array('route' => array('batch.destroy', $batch->id), 'method' => 'delete','style' => 'display:inline')) !!}
                                    <!--<button onclick="return confirm('Are You Sure ?')" class='btn btn-xs btn-danger' type="submit">Delete</button>-->
                                    {!! Form::close() !!}
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
                "ordering": true,
                "columnDefs": [
                    { "searchable": false, "targets": 10 },
                    { "orderable": false, "targets": 10 }
                ]
            })
        })
    </script>

@endsection
