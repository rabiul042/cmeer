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
                        <a href="{{ action('Admin\BatchDisciplineFeeController@create') }}"> <i class="fa fa-plus"></i> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Batch Name</th>
                            <th>Discipline</th>
                            <th>Admission Fee</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($batch_discipline_fees as $batch_discipline_fee)
                        
                            <tr>
                                <td>{{ $batch_discipline_fee->id }}</td>
                                <td>{{ (isset($batch_discipline_fee->batch->name))? $batch_discipline_fee->batch->name : '' }}</td>
                                <td>{{ (isset($batch_discipline_fee->subject->name))? $batch_discipline_fee->subject->name : '' }}</td>
                                <td>{{ $batch_discipline_fee->admission_fee }}</td>
                                <td>
                                    <a href="{{ url('admin/batch-discipline-fee/'.$batch_discipline_fee->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    {!! Form::open(array('route' => array('batch.destroy', $batch_discipline_fee->id), 'method' => 'delete','style' => 'display:inline')) !!}
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
                    { "searchable": false, "targets": 4 },
                    { "orderable": false, "targets": 4 }
                ]
            })
        })
    </script>

@endsection
