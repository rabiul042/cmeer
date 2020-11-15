@extends('admin.layouts.app')

@section('content')


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Batches Schedules Create
            </li>
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
                        <i class="fa fa-reorder"></i>Batches Schedules Create
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>'Admin\BatchesSchedulesController@store','files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="panel panel-primary"  style="border-color: #eee; ">
                            <div class="panel-heading" style="background-color: #eee; color: black; border-color: #eee; "> Select Batches Schedules Information</div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label class="col-md-1 control-label">Schedule Name (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <input type="text" name="name" placeholder="e.g: Specila Schedule - March'20" value="{{ old('name')?old('name'):'' }}" class="form-control" >
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Schedule Sub Line </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <input type="text" name="tag_line" placeholder="e.g: Every Monday & Thursday" value="{{ old('tag_line')?old('tag_line'):'' }}" class="form-control" >
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Schedule Address (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <input type="text" name="address" placeholder="Schedule Address" value="{{ old('address')?old('address'):'' }}" class="form-control" >
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-1">Room Name (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-lg-3">
                                        @php  $rooms_types->prepend('Select Room', ''); @endphp
                                        {!! Form::select('room_id',$rooms_types, old('room_id')?old('room_id'):'' ,['class'=>'form-control','required'=>'required']) !!}<i></i>
                                    </div>

                                    <label class="col-md-1 control-label">Schedule Contact Details (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>)  </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <input type="text" name="contact_details" placeholder="Schedule Contact Person and Mobile No" value="{{ old('contact_details')?old('contact_details'):'' }}" class="form-control" >
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="panel panel-primary"  style="border-color: #eee; ">
                            <div class="panel-heading" style="background-color: #eee; color: black; border-color: #eee; ">Select Batches Schedules Course Information</div>
                            <div class="panel-body">

                                <div class="years">
                                    <div class="form-group">
                                        <label class="col-md-1 control-label">Year (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                        <div class="col-md-3">
                                            <div class="input-icon right">
                                                {!! Form::select('year',$years, old('year')?old('year'):'' ,['class'=>'form-control','required'=>'required','id'=>'year']) !!}<i></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sessions">
                                    <div class="form-group">
                                        <label class="col-md-1 control-label">Session (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                        <div class="col-md-3">
                                            <div class="input-icon right">
                                                @php  $sessions->prepend('Select Session', ''); @endphp
                                                {!! Form::select('session_id',$sessions, old('session_id')?old('session_id'):'' ,['class'=>'form-control','required'=>'required','id'=>'session_id']) !!}<i></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="institutes">
                                    <div class="form-group">
                                        <label class="col-md-1 control-label">Institute (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                        <div class="col-md-3">
                                            <div class="input-icon right">
                                                @php  $institutes->prepend('Select Institute', ''); @endphp
                                                {!! Form::select('institute_id',$institutes, old('institute_id')?old('institute_id'):'' ,['class'=>'form-control','required'=>'required','id'=>'institute_id']) !!}<i></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="courses">

                                </div>


                                {{--<div class="faculties">

                                </div>

                                <div class="subjects">

                                </div>--}}

                                <div class="batches">

                                </div>

                            </div>
                        </div>

                        <div class="panel panel-primary"  style="border-color: #eee; ">
                            <div class="panel-heading" style="background-color: #eee; color: black; border-color: #eee; ">Select Batches Schedules Information</div>
                            <div class="panel-body">
                                <div class="form-group">

                                    <label class="control-label col-lg-1">Initial Schedule Date (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-lg-3">
                                        <input type="text" name="initial_date" id="initial_date" autocomplete="off" placeholder="2020-01-02" onchange="change_wd_value(this.value)" value="{{ old('initial_date')?old('initial_date'):'' }}" required class="form-control input-append date">
                                    </div>

                                    <div class="wd_ids">
                                        <label class="col-md-1 control-label">Select Batch Days (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                        <div class="col-md-3">
                                            <div class="input-icon right">
                                                {!! Form::select('wd_ids[]',$week_days, old('wd_ids')?old('wd_ids'):'' ,[ 'id'=>'id_wd_ids','class'=>'form-control select2 ', 'multiple' => 'multiple','required'=>'required']) !!}<i></i>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="form-group">

                                    <label class="col-md-1 control-label">Select Slot One (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            @php  $slots_list->prepend('Select Slot', ''); @endphp
                                            {!! Form::select('slot_type[]',$slots_list, '' ,['class'=>'form-control','required'=>'required']) !!}<i></i>
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Select Slot Time One (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" class="form-control timepicker" required name="start_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control timepicker" required  name="end_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-md-1 control-label">Select Slot Two</label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            @php  $slots_list->prepend('Select Slot', ''); @endphp
                                            {!! Form::select('slot_type[]',$slots_list,'',['class'=>'form-control']) !!}<i></i>
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Select Slot Time Two</label>
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" class="form-control timepicker" name="start_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control timepicker" name="end_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-md-1 control-label">Select Slot Three</label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            @php  $slots_list->prepend('Select Slot', ''); @endphp
                                            {!! Form::select('slot_type[]',$slots_list,'',['class'=>'form-control']) !!}<i></i>
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Select Slot Time Three</label>
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" class="form-control timepicker" name="start_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control timepicker" name="end_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-md-1 control-label">Select Slot Four</label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            @php  $slots_list->prepend('Select Slot', ''); @endphp
                                            {!! Form::select('slot_type[]',$slots_list,'',['class'=>'form-control']) !!}<i></i>
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Select Slot Time Four</label>
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" class="form-control timepicker" name="start_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control timepicker" name="end_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="form-group">

                                    <label class="col-md-1 control-label">Select Slot Five</label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            @php  $slots_list->prepend('Select Slot', ''); @endphp
                                            {!! Form::select('slot_type[]',$slots_list,'',['class'=>'form-control']) !!}<i></i>
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Select Slot Time Five</label>
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" class="form-control timepicker" name="start_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control timepicker" name="end_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label class="col-md-1 control-label">Select Slot Six</label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            @php  $slots_list->prepend('Select Slot', ''); @endphp
                                            {!! Form::select('slot_type[]',$slots_list,'',['class'=>'form-control']) !!}<i></i>
                                        </div>
                                    </div>

                                    <label class="col-md-1 control-label">Select Slot Time Six</label>
                                    <div class="col-md-3">
                                        <div class="input-group date">
                                            <input type="text" class="form-control timepicker" name="start_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control timepicker" name="end_time[]" value="">
                                            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>--}}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-1 control-label">Select Status</label>
                            <div class="col-md-3">
                                {!! Form::select('status', ['1' => 'Active','0' => 'InActive'], old('status'),['class'=>'form-control']) !!}<i></i>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-9">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ url('admin/batches-schedules') }}" class="btn btn-default">Cancel</a>
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

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js" type="text/javascript"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>



    <script type="text/javascript">

        /*function change_wd_value( value_to_set ){
            var given_date = new Date(value_to_set);
            var given_date_weekday = given_date.getDay();
            $("#id_wd_ids").val(given_date_weekday);
            $('#id_wd_ids').trigger('change');
        }*/

        function change_wd_value( value_to_set ){
            var week_day_numbers_js_to_php = { 0:7, 1:1, 2:2, 3:3, 4:4, 5:5, 6:6, 7:7 };
            var given_date = new Date(value_to_set);
            var given_date_weekday_number_for_js = given_date.getDay();
            var given_date_weekday_number_for_php = week_day_numbers_js_to_php[given_date_weekday_number_for_js];
            $("#id_wd_ids").val(given_date_weekday_number_for_php);
            $('#id_wd_ids').trigger('change');
        }


        $(document).ready(function() {

            $('.timepicker').datetimepicker({
                format: 'LT'
            });

            $('#initial_date').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                startDate: '1900-01-01',
                endDate: '2035-01-01',
            }).on('changeDate', function(e){
                $(this).datepicker('hide');
            });

            $("body").on( "change", "[name='institute_id']", function() {
                var institute_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/institutes-courses',
                    dataType: 'HTML',
                    data: { institute_id : institute_id },
                    success: function( data ) {
                        $('.courses').html(data);
                        $('.faculties').html('');
                        $('.subjects').html('');
                    }
                });
            });

            $("body").on( "change", "[name='course_id']", function() {
                var course_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/courses-batches',
                    dataType: 'HTML',
                    data: { course_id : course_id },
                    success: function( data ) {
                        $('.batches').html(data);
                    }
                });
            });

            /*$("body").on( "change", "[name='faculty_id']", function() {
                var faculty_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/faculties-subjects-for-batches-schedules',
                    dataType: 'HTML',
                    data: { faculty_id : faculty_id },
                    success: function( data ) {
                        $('.subjects').html(data);
                    }
                });
            });

            $("body").on( "change", "[name='subject_id']", function() {

                var course_id = $('#course_id').val();
                var faculty_id = $('#faculty_id').val();
                var subject_id = $(this).val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/courses-faculties-subjects-batches',
                    dataType: 'HTML',
                    data: { course_id : course_id , faculty_id : faculty_id,  subject_id : subject_id },
                    success: function( data ) {
                        $('.batches').html(data);
                    }
                });
            });*/

            $("body").on( "change", "[name='batch_id']", function() {

                var year = $('#year').val().slice(-2);
                var session_id = $('#session_id').val();
                var course_id = $('#course_id').val();
                var faculty_id = $('#faculty_id').val();
                var subject_id = $('#subject_id').val();
                var batch_id = $('#batch_id').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/reg-no',
                    dataType: 'HTML',
                    data: { year : year, session_id : session_id, course_id : course_id , faculty_id : faculty_id,  subject_id : subject_id, batch_id : batch_id },
                    success: function( data ) {
                        $('.reg_no').html(data);
                    }
                });
            });

            $('.select2').select2({
                //'placeholder':"Select Topic"
            });
        })
    </script>


@endsection