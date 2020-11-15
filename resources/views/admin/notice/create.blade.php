@extends('admin.layouts.app')

@section('content')


    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li> <i class="fa fa-angle-right"> </i> <a href="#">Notice</a></li>
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
                        <i class="fa fa-reorder"></i>Notice Create
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>'Admin\NoticeController@store','files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">


                        <div class="form-group">
                            <label class="col-md-2 control-label">Title <i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i></label>
                            <div class="col-md-10">
                                <div class="input-icon right">
                                    <input type="text" name="title" required value="{{ old('head') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Attachment </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input class="form-control" type="file" name="attachment" value="{{ old('attachment')?old('attachment'):'' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Select Notice Type (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                {!! Form::select('type', [''=>'Select Type', 'I' => 'Individual', 'A' => 'All', 'B' => 'Batch'], old('type'),['class'=>'form-control','required'=>'required']) !!}<i></i>
                            </div>
                        </div>

                        <div class="next_data"></div>
                        <div class="course"></div>
                        <div class="batch"></div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Type Notice </label>
                            <div class="col-md-10">
                                <div class="input-icon right">
                                    <textarea name="notice" required></textarea>
                                </div>
                            </div>
                        </div>
                                
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ url('admin/coming-by') }}" class="btn btn-default">Cancel</a>
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

    

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.js" type="text/javascript"></script>

    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    
    

    <script type="text/javascript">
        $(document).ready(function() {

            CKEDITOR.replace( 'notice' );

            $("body").on( "change", "[name='type']", function() {
                var type = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/notice-type',
                    dataType: 'HTML',
                    data: {type : type},
                    success: function( data ) {
                        $('.next_data').html(data);
                        $('.course').html('');
                        $('.batch').html('');

                        $('.doctor_list').select2({
                            minimumInputLength: 3,
                            escapeMarkup: function (markup) { return markup; },
                            language: {
                                noResults: function () {
                                    return "No Doctor found, for add new Doctor please <a target='_blank' href='{{ url('admin/doctors/create') }}'>Click here</a>";
                                }
                            },
                            ajax: {
                                url: '/admin/search-doctors',
                                dataType: 'json',
                                type: "GET",
                                quietMillis: 50,
                                data: function (term) {
                                    return {
                                        term: term,
                                        type: 1
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
                        }).trigger('change');
                        
                    }
                });
            })



            $("body").on( "change", "[name='institute_id']", function() {
                var institute_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/notice-institute-course',
                    dataType: 'HTML',
                    data: {institute_id: institute_id},
                    success: function( data ) {
                        $('.course').html(data);
                        $('.batch').html('');
                    }
                });
            })



            $("body").on( "change", "[name='course_id']", function() {
                var course_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/notice-course-batch',
                    dataType: 'HTML',
                    data: {course_id: course_id},
                    success: function( data ) {
                        $('.batch').html(data);
                    }
                });
            })




        })
    </script>


@endsection