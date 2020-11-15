@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Change Password</h3></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="col-md-12">

                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                {!! Form::open(['url'=>['update-password'],'method'=>'post','files'=>true,'class'=>'form-horizontal']) !!}


                                <div class="form-body">
                                    <!--
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="input-icon right">
                                                Current Password <br>
                                                <input type="password" name="current_password" required value="{{ old('current_password') }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="input-icon right">
                                                New Password<br>
                                                <input type="password" name="new_password" required value="{{ old('new_password') }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="input-icon right">
                                                Confirm New Password<br>
                                                <input type="password" name="confirm_password" required value="{{ old('confirm_password') }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-0 col-md-9">
                                                <button type="submit" class="btn btn-info">Change Password</button>
                                                <a href="{{ url('my-profile') }}" class="btn btn-default">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                            {!! Form::close() !!}

                            <!-- END FORM-->
                            </div>

                        </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
