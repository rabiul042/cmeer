@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>Discipline List</li>
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
                        <i class="fa fa-globe"></i>Discipline List
                        <a href="{{ action('Admin\SubjectsController@create') }}"> <i class="fa fa-plus"></i> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Discipline Name</th>
                            <th>OMR Code</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Faculty</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->id }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->subject_omr_code }}</td>
                                <td>{{ (isset($subject->institute->name))?$subject->institute->name:'' }}</td>
                                <td>{{ (isset($subject->course->name))?$subject->course->name:'' }}</td>
                                <td>{{ (isset($subject->faculty->name))?$subject->faculty->name:'' }} </td>
                                <td>
                                    <a href="{{ url('admin/subjects/'.$subject->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    {!! Form::open(array('route' => array('subjects.destroy', $subject->id), 'method' => 'delete','style' => 'display:inline')) !!}
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
                    { "searchable": false, "targets": 5 },
                    { "orderable": false, "targets": 5 }
                ]
            })
        })
    </script>

@endsection
