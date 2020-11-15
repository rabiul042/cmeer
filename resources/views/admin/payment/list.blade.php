@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>Payment List</li>
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
                        <i class="fa fa-globe"></i>Payment List
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover userstable datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Doctor Name</th>
                            <th>Reg No</th>
                            <th>Trans ID</th>
                            <th>Paid Amount</th>
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
                ajax: '/admin/payment-list',
                "pageLength": 25,
                columns: [
                    {data: 'id',name:'d1.id'},
                    {data: 'created_at',name:'d1.created_at'},
                    {data: 'doctor_name',name:'d3.name'},
                    {data: 'reg_no',name:'d2.reg_no'},
                    {data: 'trans_id',name:'d1.trans_id'},
                    {data: 'amount',name:'d1.amount'},
                ]
            })
        })
    </script>

@endsection