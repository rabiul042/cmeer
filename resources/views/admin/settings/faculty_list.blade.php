@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>Faculty List</li>
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
                        <i class="fa fa-globe"></i>Faculty List 
                        <a href="{{ action('Admin\FacultyController@create') }}"> <i class="fa fa-plus"></i> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>OMR Code</th>
                            <th>Faculty Name</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($faculty as $faculty)
                            <tr>
                                <td>{{ $faculty->id }}</td>
                                <td>{{ (isset($faculty->institute->name))?$faculty->institute->name:'' }}</td>
                                <td>{{ (isset($faculty->course->name))?$faculty->course->name:'' }}</td>
                                <td>{{ $faculty->faculty_omr_code }}</td>
                                <td>{{ $faculty->name }}</td>
                                <td>
                                    <a href="{{ url('admin/faculty/'.$faculty->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    {!! Form::open(array('route' => array('faculty.destroy', $faculty->id), 'method' => 'delete','style' => 'display:inline')) !!}
                                    <button onclick="return confirm('Are You Sure ?')" class='btn btn-xs btn-danger' type="submit">Delete</button>
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
                "columnDefs": [
                    { "searchable": false, "targets": 4 },
                    { "orderable": false, "targets": 4 }
                ]
            })
        })
    </script>

@endsection