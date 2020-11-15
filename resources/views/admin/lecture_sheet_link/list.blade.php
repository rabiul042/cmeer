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
                        @can('Lecture Sheet Link')
                        <a href="{{url('admin/lecture-sheet-link/create')}}"> <i class="fa fa-plus"></i> </a>
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

                        @foreach($lecture_sheet_links as $lecture_sheet_link)
                            <tr>
                                <td>{{ $lecture_sheet_link->id }}</td>
                                <td>{{ $lecture_sheet_link->year }}</td>
                                <td>{{ $lecture_sheet_link->session->name }}</td>
                                <td>{{ $lecture_sheet_link->branch ? $lecture_sheet_link->branch->name : ''  }}</td>
                                <td>{{ $lecture_sheet_link->institute->name }}</td>
                                <td>{{ $lecture_sheet_link->course->name }}</td>
                                <td>{{ $lecture_sheet_link->batch->name }}</td>
                                <td>{{ ($lecture_sheet_link->status==1)?'Active':'InActive' }}</td>
                                <td>
                                    @can('Lecture Sheet Link')
                                    <a href="{{ url('admin/lecture-sheet-link/'.$lecture_sheet_link->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Lecture Sheet Link')
                                    {!! Form::open(array('route' => array('lecture-sheet-link.destroy', $lecture_sheet_link->id), 'method' => 'delete','style' => 'display:inline')) !!}
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
                    { "searchable": false, "targets": 7 },
                    { "orderable": false, "targets": 7 }
                ]
            })
        })
    </script>

@endsection