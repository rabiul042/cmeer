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
                {{ $title }}
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
                        <i class="fa fa-reorder"></i>{{ $title }}
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>['Admin\QuestionTypesController@store'],'files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Question Type Title (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="text" name="title" required value="{{ old('title') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Number of MCQ (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="mcq_number" required value="{{ old('mcq_number') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mark of MCQ (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="mcq_mark" required value="{{ old('mcq_mark') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">MCQ Negative Mark/stamp (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="mcq_negative_mark" step="any" required value="{{ old('mcq_negative_mark') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Number of SBA (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="sba_number" required value="{{ old('sba_number') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Mark of SBA (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="sba_mark" required value="{{ old('sba_mark') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Negative Mark/stamp (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="sba_negative_mark" step="any" required value="{{ old('sba_negative_mark') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="col-md-2 control-label">Full Mark</label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="full_mark" required value="{{ old('full_mark') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="form-group">
                            <label class="col-md-2 control-label">Pass Mark (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="pass_mark" required value="{{ old('pass_mark') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Duration ( In Minutes ) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <input type="number" name="duration" required value="{{ old('title') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Paper or Faculty (BCPS) </label>
                            <div class="col-md-4" id="id_div_doctors_gender">
                                <label class="radio-inline"><input type="radio" name="paper_faculty" value="Paper"> Paper</label>
                                <label class="radio-inline"><input type="radio" name="paper_faculty" value="Faculty"> Faculty</label>
                                <label class="radio-inline"><input type="radio" name="paper_faculty" value="None" checked> None</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">Is Faculty ? </label>
                            <div class="col-md-4" id="id_div_doctors_gender">
                                <label class="radio-inline"><input type="radio" required name="is_faculty" value="Yes" {{  old('is_faculty') === "Yes" ? "checked" : '' }} > Yes</label>
                                <label class="radio-inline"><input type="radio" required name="is_faculty" value="No" {{  old('is_faculty') === "No" ? "checked" : '' }}> No</label>
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
            <!-- END EXAMPLE TABLE PORTLET-->



        </div>
    </div>

    <!-- END PAGE CONTENT-->


@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function() {

            $("body").on( "change", "[name='book_id']", function() {
                var book_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/book-subject',
                    dataType: 'HTML',
                    data: {book_id: book_id},
                    success: function( data ) {
                        $('.subject').html(data);
                    }
                });
            })

            $("body").on( "change", "[name='subject_id']", function() {
                var subject_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/admin/subject-chapter',
                    dataType: 'HTML',
                    data: {subject_id: subject_id},
                    success: function( data ) {
                        $('.chapter').html(data);
                    }
                });
            })

        })
    </script>


@endsection
