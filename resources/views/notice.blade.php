@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Notice</h3></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($notices as $notice)
                                            @if ($notice->type=='A')
                                                <tr>
                                                    <td>{{ $notice->id }}</td>
                                                    <td>{{ $notice->title }}</td>
                                                    <td>
                                                        <a href="{{ url('notice/notice-details/'.$notice->id) }}" class="btn btn-xs btn-primary">More Details</a>
                                                    </td>
                                                </tr>
                                            @endif

                                            @foreach($doctor_notices as $doctor_notice)
                                                @if (($notice->type=='I') && ($doctor_notice->notice_id==$notice->id))
                                                    <tr>
                                                        <td>{{ $notice->id }}</td>
                                                        <td>{{ $notice->title }}</td>
                                                        <td>
                                                            <a href="{{ url('notice/notice-details/'.$notice->id) }}" class="btn btn-xs btn-primary">More Details</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            @foreach($batch_notices as $batch_notice)
                                                @if (($notice->type=='B') && ($batch_notice->batch_id==$notice->batch_id))
                                                    <tr>
                                                        <td>{{ $notice->id }}</td>
                                                        <td>{{ $notice->title }}</td>
                                                        <td>
                                                            <a href="{{ url('notice/notice-details/'.$notice->id) }}" class="btn btn-xs btn-primary">More Details</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach


                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>

    </div>


</div>
@endsection
