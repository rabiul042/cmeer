@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/admin') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>{{ $title }}</li>
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
                        <i class="fa fa-reorder"></i>{{ $title }}
                    </div>
                </div>
                <div>
                    <?php
                    //echo '<pre>';
                    //print_r($question_type);
                    ?>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>['Admin\QuestionTypesController@update',$type_info->id],'method'=>'PUT','files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Question Type Title (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="text" name="title" required value="{{ $type_info->title }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Number of MCQ (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="mcq_number" required value="{{ $type_info->mcq_number }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mark of MCQ (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="mcq_mark" step="any" required value="{{ $type_info->mcq_mark }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">MCQ Negative Mark/stamp (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="mcq_negative_mark" step="any"  value="{{ $type_info->mcq_negative_mark }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Number of SBA (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="sba_number" required value="{{ $type_info->sba_number }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mark of SBA (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="sba_mark" step="any" required value="{{ $type_info->sba_mark }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Negative Mark/stamp (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="sba_negative_mark" step="any" value="{{ $type_info->sba_negative_mark }}" class="form-control">
                                </div>
                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label class="col-md-2 control-label">Full Mark</label>--}}
{{--                            <div class="col-md-4">--}}
{{--                                <div class="input-icon right">--}}
{{--                                    <input type="number" name="full_mark" required value="{{ $type_info->full_mark }}" class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label class="col-md-2 control-label">Pass Mark (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="pass_mark" required value="{{ $type_info->pass_mark }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Duration ( In Minutes ) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="duration" required value="{{ $duration }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Paper or Faculty (BCPS) </label>
                            <div class="col-md-4" id="id_div_doctors_gender">
                                <label class="radio-inline"><input type="radio" name="paper_faculty" value="Paper" {{ $type_info->paper_faculty === "Paper" ? "checked" : '' }} > Paper</label>
                                <label class="radio-inline"><input type="radio" name="paper_faculty" value="Faculty" {{ $type_info->paper_faculty === "Faculty" ? "checked" : '' }}> Faculty</label>
                                <label class="radio-inline"><input type="radio" name="paper_faculty" value="None" {{ $type_info->paper_faculty === "None" ? "checked" : '' }}> None</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ url('admin/question-types') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- END FORM-->
                </div>
            </div>

        </div>
    </div>



@endsection

@section('js')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '1900-01-01',
            endDate: '2020-12-30',
        }).on('changeDate', function(e){
            $(this).datepicker('hide');
        });



        $("body").on( "change", "[name='permanent_division_id']", function() {
            var permanent_division_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/admin/permanent-division-district',
                dataType: 'HTML',
                data: {permanent_division_id: permanent_division_id},
                success: function( data ) {
                    $('.permanent_district').html(data);
                }
            });
        });

        $("body").on( "change", "[name='permanent_district_id']", function() {
            var permanent_district_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/admin/permanent-district-upazila',
                dataType: 'HTML',
                data: {permanent_district_id: permanent_district_id},
                success: function( data ) {
                    $('.permanent_upazila').html(data);
                }
            });
        });

        $("body").on( "change", "[name='present_division_id']", function() {
            var present_division_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/admin/present-division-district',
                dataType: 'HTML',
                data: {present_division_id: present_division_id},
                success: function( data ) {
                    $('.present_district').html(data);
                }
            });
        });

        $("body").on( "change", "[name='present_district_id']", function() {
            var present_district_id = $(this).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/admin/present-district-upazila',
                dataType: 'HTML',
                data: {present_district_id: present_district_id},
                success: function( data ) {
                    $('.present_upazila').html(data);
                }
            });
        });

        $(document).ready(function() {

            //$('.select2').select2();

        })
    </script>




@endsection
