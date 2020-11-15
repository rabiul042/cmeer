@extends('admin.layouts.app')

@section('content')


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>{{$title}}</li>
        </ul>

    </div>

    @if(Session::has('message'))
        <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-success' }}" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>{{$title}}
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>['Admin\BatchController@store'],'files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Batch Name (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" name="name" required value="{{ old('name') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Batch Code (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="batch_code" required value="{{ old('batch_code') }}" maxlength="2" minlength="2" class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Start Range (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="start_index" required value="{{ old('start_index') }}" minlength="3" maxlength="3" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">End Range (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="end_index" required value="{{ old('end_index') }}" minlength="3" maxlength="3" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Branch (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                @php  $branches->prepend('Select Branch', ''); @endphp
                                {!! Form::select('branch_id',$branches, old('branch_id'),['class'=>'form-control','required'=>'required']) !!}<i></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Institute (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                @php  $institute->prepend('Select Institute', ''); @endphp
                                {!! Form::select('institute_id',$institute, old('institute_id'),['class'=>'form-control','required'=>'required']) !!}<i></i>
                            </div>
                        </div>

                        <div class="course">

                        </div>

                        <div class="subject">

                        </div>

                        {{--<div class="form-group">
                            <label class="col-md-3 control-label">Admission Fee Type (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                {!! Form::select('fee_type', ['Batch' => 'Batch'], old('fee_type'),['class'=>'form-control','required'=>'required','id'=>'fee_type']) !!}<i></i>
                            </div>
                        </div>--}}
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Admission Fee (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="admission_fee" min="0" required value="0" class="form-control">
                                </div>
                            </div>
                        </div>                        

                        <div class="form-group"> 
                            <label class="col-md-3 control-label">Minimum Payment (%) (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="minimum_payment" min="0" value="100" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Payment Times (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="payment_times" value="0" min="0" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Batch Details</label>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <textarea id="details" name="details">{{ old('details')?old('details'):'' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Status (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                {!! Form::select('status', ['1' => 'Active','0' => 'InActive'], old('status'),['class'=>'form-control','required'=>'required']) !!}<i></i>
                            </div>
                        </div>


                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ url('admin/batch') }}" class="btn btn-default">Cancel</a>
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

            CKEDITOR.replace( 'details' );

            $("body").on( "change", "[name='institute_id']", function() {
                var institute_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/institute-course',
                    dataType: 'HTML',
                    data: {institute_id : institute_id},
                    success: function( data ) {
                        $('.course').html(data);
                        $('.faculty').html('');
                        $('.subject').html('');
                    }
                });
            })

            $("body").on( "change", "[name='course_id']", function() {
                var institute_id = $("[name='institute_id']").val();
                var course_id = $(this).val();
                if(institute_id == '4'){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        //url: '/admin/'+$("[name='url']").val(),
                        url: '/admin/course-subjects',
                        dataType: 'HTML',
                        data: {course_id: course_id},
                        success: function( data ) {
                            $('.subject').html('');
                            $('.subject').html(data);
                        }
                    });
                }
            })

            $("body").on( "change", "[name='faculty_id']", function() {
                var faculty_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/faculty-subject',
                    dataType: 'HTML',
                    data: {faculty_id: faculty_id},
                    success: function( data ) {
                        $('.subject').html(data);
                    }
                });
            })

            $("body").on( "change", "#fee_type", function() {
                var fee_type = $(this).val();
                if(fee_type == "Discipline")
                {
                    $("[name='admission_fee']").prop("disabled", true);
                }
                if(fee_type == "Batch")
                {
                    $("[name='admission_fee']").prop("disabled", false);
                }
            })

        })
    </script>


@endsection