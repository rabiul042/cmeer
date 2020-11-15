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
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class/Chapter Name</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($topics as $topic)
                            
                            <tr>
                                <td>{{ $topic->id }}</td>
                                <td>{{ $topic->name }}</td>
                                <td>{{ (isset($topic->course->name))?$topic->course->name:'' }}</td>
                                <td>
                                    @can('Topic Edit')
                                    <a href="{{ url('admin/topic/'.$topic->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Topic Delete')
                                    {!! Form::open(array('route' => array('topic.destroy', $topic->id), 'method' => 'delete','style' => 'display:inline')) !!}
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
                    { "searchable": false, "targets": 3 },
                    { "orderable": false, "targets": 3 }
                ]
            })
        })
    </script>

@endsection
