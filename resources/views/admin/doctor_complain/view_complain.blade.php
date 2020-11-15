@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/admin') }}">Home</a></i>
            </li>
            <?php
            $urls='';
            foreach($breadcrumb as $key=>$value){ $urls .= $value.'/';
                echo '<li> <i class="fa fa-angle-right"></i> <a href="'.url('/').substr_replace($urls, "", -1).'"> '.$value.' </a></li>';
            }
            ?>
        </ul>
    </div>

    @if(Session::has('message'))
        <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-success' }}" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Conversations 
                    </div>
                </div>
                <div class="portlet-body form">
                    <table class="table table-bordered table-hover">
                    @foreach($doctor_complain_replies as $key => $doctor_complain_reply)
                        <tr style="background-color: {{ ($doctor_complain_reply->user_id!=0)?'#FFFFFF':'#E9E9E9' }} ;">
                        
                            <td style="width:30%;">{{($doctor_complain_reply->user_id !=0 )? $doctor_complain_reply->user->name : $doctor_complain_reply->doctor->name.' ( '.$doctor_complain_reply->doctor->id.' ) ' }} : </td> 
                            <td style="width:70%;">{!! $doctor_complain_reply->message !!}</td>
                        
                        </tr>
                    @endforeach
                    </table>                    
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->



        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Reply
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>['Admin\DoctorComplainController@reply_complain'],'method'=>'POST','files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Doctor (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="hidden" name="doctor_id" required value="{{ $doctor_complain_reply->doctor_id ? $doctor_complain_reply->doctor_id :'' }}">                                   
                                    <input type="text" class="form-control" name="doctor_name" disabled required value="{{ $doctor_complain_reply->doctor_id ? $doctor_complain_reply->doctor->name.' ( '.$doctor_complain_reply->doctor->id.' ) ' :'' }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">User (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="hidden" name="user_id" required value="{{ $user->id ? $user->id :'' }}">                                
                                    <input type="text" class="form-control" name="user_name" disabled required value="{{ $user->name ? $user->name :'' }}">
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="doctor_complain_id" required value="{{ $doctor_complain_reply->doctor_complain_id ? $doctor_complain_reply->doctor_complain_id :'' }}">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Message (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <textarea id="message" name="message">{{ old('message')?old('message'):'' }}</textarea>
                                </div>
                            </div>
                        </div>

                        

                    </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-info">{{ $submit_value }}</button>
                                <a href="{{ url('admin/doctor-complain-reply') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                
                {!! Form::close() !!}
                <!-- END FORM-->
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->



        </div>
    </div>
    <!-- END PAGE CONTENT-->


@endsection

@section('js')

    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>    

    <script type="text/javascript">
        $(document).ready(function() {
            CKEDITOR.replace( 'message' );
        })
    </script>


@endsection
