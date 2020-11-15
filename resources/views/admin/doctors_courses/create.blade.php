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
                Doctor Course Create
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
                        <i class="fa fa-reorder"></i>Doctor Course Create
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>'Admin\DoctorsCoursesController@store','files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="panel panel-primary"  style="border-color: #eee; ">
                            <div class="panel-heading" style="background-color: #eee; color: black; border-color: #eee; "> Select Doctor Information</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Doctor (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <select name="doctor_id" required class="form-control doctor2">
                                            </select>
                                          {{--  @php  $doctors->prepend('Typing name or bmdc no', ''); @endphp
                                            {!! Form::select('doctor_id',$doctors, old('doctor_id')?old('doctor_id'):'' ,['class'=>'form-control select2','required'=>'required']) !!}<i></i>--}}
                                        </div>
                                    </div>                                    

                                </div>

                                <div class="form-group">
                                        <label class="col-md-3 control-label">Refer By</label>
                                        <div class="col-md-3">
                                            <input type="text" name="refer_by" class="form-control">
                                        </div>
                                </div>

                            </div>
                        </div>

                        <div class="panel panel-primary"  style="border-color: #eee; ">
                            <div class="panel-heading" style="background-color: #eee; color: black; border-color: #eee; ">Select Doctor Course Information</div>
                            <div class="panel-body">

                                <div class="years">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Year (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                        <div class="col-md-3">
                                            <div class="input-icon right">
                                                {!! Form::select('year',$years, old('year')?old('year'):'' ,['class'=>'form-control','required'=>'required','id'=>'year']) !!}<i></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sessions">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Session (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                                        <div class="col-md-3">
                                            <div class="input-icon right">
                                                @php  $sessions->prepend('Select Session', ''); @endphp
                                                {!! Form::select('session_id',$sessions, old('session_id')?old('session_id'):'' ,['class'=>'form-control','required'=>'required','id'=>'session_id']) !!}<i></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Branch (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                                    <div class="col-md-3">
                                        @php  $branches->prepend('Select Branch', ''); @endphp
                                        {!! Form::select('branch_id',$branches, old('branch_id'),['class'=>'form-control','required'=>'required']) !!}<i></i>
                                    </div>
                                </div>

                                <div class="institutes">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Institute (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
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

                                <div class="faculties">

                                </div>

                                <div class="subjects">

                                </div>

                                <div class="batches">

                                </div>

                                <div class="reg_no">

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Reg No. (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span id="reg_no_first_part" class="input-group-addon"></span>
                                    <input type="hidden" name="reg_no_first_part" required value="">
                                    <input type="text" name="reg_no_last_part" value="" required class="form-control" placeholder="_ _ _" >
                                </div>
                                <div><span id="range" class="" style="color:green;font-weight:700;"></span></div>
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
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ url('admin/doctors-courses') }}" class="btn btn-default">Cancel</a>
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


    <script type="text/javascript">
        $(document).ready(function() {


            $('.doctor2').select2({
                minimumInputLength: 3,
                placeholder: "Please type doctor's name or bmdc no",
                escapeMarkup: function (markup) { return markup; },
                language: {
                    noResults: function () {
                        return "No Doctors found, for add new doctor please <a target='_blank' href='{{ url('admin/doctors/create') }}'>Click here</a>";
                    }
                },
                ajax: {
                    url: '/admin/search-doctors',
                    dataType: 'json',
                    type: "GET",
                    quietMillis: 50,
                    data: function (term) {
                        return {
                            term: term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return { id:item.id , text: item.name_bmdc };
                            })
                        };
                    }
                }
            });

            $("body").on( "change", "[name='institute_id']", function() {
                var institute_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/branch-institute-courses',
                    dataType: 'HTML',
                    data: {institute_id : institute_id},
                    success: function( data ) {
                        $('.courses').html('');
                        $('.faculties').html('');
                        $('.subjects').html('');
                        $('.batches').html('');
                        $('.reg_no').html('');
                        $('#reg_no_first_part').text('');
                        $('[name="reg_no_last_part"]').val('');
                        $('#range').text('');
                        $('.courses').html(data);
                    }
                });
            })

            $("body").on( "change", "[name='course_id'],[name='branch_id']", function() {
                var branch_id = $("[name='branch_id']").val();
                var institute_id = $("[name='institute_id']").val();
                var course_id = $("[name='course_id']").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/'+$("[name='url']").val(),
                    dataType: 'HTML',
                    data: {branch_id:branch_id,institute_id:institute_id,course_id: course_id},
                    success: function( data ) {
                        var data = JSON.parse(data);
                        $('.faculties').html('');
                        $('.subjects').html('');
                        $('.batches').html('');
                        $('.reg_no').html('');
                        $('#reg_no_first_part').text('');
                        $('[name="reg_no_last_part"]').val('');
                        $('#range').text('');
                        $('.faculties').html(data['faculties']);
                        $('.subjects').html(data['subjects']);
                        $('.batches').html(data['batches']);
                        
                    }
                });

            })

            $("body").on( "change", "[name='faculty_id']", function() {
                var institute_id = $("[name='institute_id']").val();
                var course_id = $("[name='course_id']").val();
                var faculty_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/faculty-subjects',
                    dataType: 'HTML',
                    data: {institute_id:institute_id,course_id:course_id,faculty_id: faculty_id},
                    success: function( data ) {
                        $('.subjects').html(data);
                    }
                });
            })

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
                        //$('.batches').html(data);
                    }
                });
            });

            $("body").on( "change", "[name='batch_id'],[name='session_id'],[name='year']", function() {

                var year = $('#year').val().slice(-2);
                var session_id = $('#session_id').val();
                var course_id = $('#course_id').val();
                var batch_id = $('#batch_id').val();

                if(year && session_id && course_id && batch_id) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: '/admin/reg-no',
                        dataType: 'HTML',
                        data: {year: year, session_id: session_id, course_id: course_id, batch_id: batch_id},
                        success: function (data) {
                            var data = JSON.parse(data);
                            $('#reg_no_first_part').text(data['reg_no_first_part']);
                            $('[name="reg_no_first_part"]').val(data['reg_no_first_part']);
                            $('#range').text(data['range']);
                        }
                    });
                }
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




        })
    </script>


@endsection
