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
                        <i class="fa fa-reorder"></i>{{ $title }}}
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['action'=>['Admin\SbaController@store'],'files'=>true,'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Question Title (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <textarea name="question_title" required class="form-control">{{ old('question_title') }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (A) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" name="question_a" required value="{{ old('question_a') }}" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (B) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" name="question_b" required value="{{ old('question_b') }}" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (C) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" name="question_c" required value="{{ old('question_c') }}" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (D) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" name="question_d" required value="{{ old('question_d') }}" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (E) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <input type="text" name="question_e" required value="{{ old('question_e') }}" class="form-control">
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Correct Answer (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <label class="radio-inline"><input type="radio" name="correct_ans" value="A" {{  old('correct_ans') === "A" ? "required" : 'required' }} > A </label>
                                <label class="radio-inline"><input type="radio" name="correct_ans" value="B" {{  old('correct_ans') === "B" ? "required" : 'required' }} > B </label>
                                <label class="radio-inline"><input type="radio" name="correct_ans" value="C" {{  old('correct_ans') === "C" ? "required" : 'required' }} > C </label>
                                <label class="radio-inline"><input type="radio" name="correct_ans" value="D" {{  old('correct_ans') === "D" ? "required" : 'required' }} > D </label>
                                <label class="radio-inline"><input type="radio" name="correct_ans" value="E" {{  old('correct_ans') === "E" ? "required" : 'required' }} > E </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Discussion</label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <textarea name="discussion" class="form-control">{{ old('discussion') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Reference</label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <textarea name="reference" class="form-control">{{ old('reference') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <a href="{{ url('admin/sba') }}" class="btn btn-default">Cancel</a>
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