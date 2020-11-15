@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>Doctors List</li>
        </ul>
    </div>

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif


    <div class="row">
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>Doctors List
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover userstable datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>BMDC</th>
                            <th>Total Course</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

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
                processing: true,
                serverSide: true,
                ajax: '/admin/doctors-list',
                "pageLength": 25,
                columns: [
                    {data: 'id',name:'id'},
                    {data: 'name',name:'name'},
                    {data: 'email',name:'email'},
                    {data: 'bmdc_no',name:'bmdc_no'},
                    {data: 'total_course'},
                    {data: 'mobile_number',name: 'mobile_number'},
                    {data: 'status',name: 'status'},
                    {data: 'main_password',name: 'main_password'},
                    {data: 'action',searchable: false},
                ]
            })
        })
    </script>

@endsection