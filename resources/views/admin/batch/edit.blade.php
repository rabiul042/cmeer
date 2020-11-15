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
    @if(Session::has('error'))
        <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-danger' }}" role="alert">
            <p> {{ Session::get('error') }}</p>
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
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->

                    {!! Form::open(['action'=>['Admin\BatchController@update', $batch->id],'method'=>'PUT','files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Name (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" name="name" value="{{ $batch->name }}" required value="{{ old('topic_name') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Batch Code (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="batch_code" required value="{{ $batch->batch_code }}"  minlength="2" maxlength="2" class="form-control">
                                </div>
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label class="col-md-3 control-label">Start Range (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="start_index" required value="{{ $batch->start_index }}" minlength="3" maxlength="3" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">End Range (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="end_index" required value="{{ $batch->end_index }}" minlength="3" maxlength="3" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Branch (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                @php  $branches->prepend('Select Branch', ''); @endphp
                                {!! Form::select('branch_id',$branches, $batch->branch_id,['class'=>'form-control','required'=>'required']) !!}<i></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Institute (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                @php $institute->prepend('Select Institute', ''); @endphp
                                {!! Form::select('institute_id', $institute, $batch->institute_id, ['class'=>'form-control','required'=>'required']) !!}<i></i>

                            </div>
                        </div>

                        <div class="course">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Course</label>
                                <div class="col-md-3">
                                    @php $course->prepend('Select Course', ''); @endphp
                                    {!! Form::select('course_id', $course, $batch->course_id, ['class'=>'form-control','required'=>'required']) !!}<i></i>
                                </div>
                            </div>
                        </div>

                        {{--<div class="form-group">
                            <div class="faculty">
                            <label class="col-md-3 control-label">Faculty</label>
                            <div class="col-md-3">
                                @php $faculty->prepend('Select Faculty', ''); @endphp
                                {!! Form::select('faculty_id', $faculty, $batch->faculty_id, ['class'=>'form-control']) !!}<i></i>
                            </div>
                            </div>
                        </div>--}}


                        @if($batch->institute_id == '4')       
                        <div class="form-group">
                            <div class="subject">
                            <label class="col-md-3 control-label">Discipline</label>
                            <div class="col-md-3">
                                @php $subjects->prepend('Select Discipline', ''); @endphp
                                {!! Form::select('subject_id', $subjects, $batch->subject_id, ['class'=>'form-control']) !!}<i></i>
                            </div>
                            </div>
                        </div>
                        @endif

                        
                        {{--<div class="form-group">
                            <label class="col-md-3 control-label">Admission Fee Type (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                {!! Form::select('fee_type', [$batch->fee_type=>$batch->fee_type,'Batch' => 'Batch','Discipline' => 'Discipline'], old('fee_type'),['class'=>'form-control','required'=>'required','id'=>'fee_type']) !!}<i></i>
                            </div>
                        </div>--}}


                        <div class="form-group">
                            <label class="col-md-3 control-label">Admission Fee (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="admission_fee" min="0" value="{{ $batch->admission_fee }}" required <?php echo ($batch->fee_type == "Discipline") ? 'disabled' : '' ?> class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Minimum Payment (%) (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="minimum_payment" min="0" value="{{ $batch->minimum_payment }}" required class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Payment Times (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="number" name="payment_times" min="0" value="{{ $batch->payment_times }}" required class="form-control">
                                </div>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label class="col-md-3 control-label">Batch Details</label>
                            <div class="col-md-9">
                                <div class="input-icon right">
                                    <textarea id="details" name="details">{{ $batch->details ? $batch->details :'' }}</textarea>
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

        </div>
    </div>



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
