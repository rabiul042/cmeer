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
                    {!! Form::open(['action'=>['Admin\SbaController@update', $questions->id], 'method'=>'PUT', 'files'=>true, 'class'=>'form-horizontal']) !!}
                    <div class="form-body">

                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Question Title (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <textarea name="question_title" required class="form-control">{{ $questions->question_title }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (A) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    @php
                                        $qa = \App\Question_ans::select('id','answer', 'sl_no')->where('question_id',$questions->id)->where('sl_no', 'A')->first();
                                        echo "<input class=form-control type='text' name='question_a' required value='".$qa->answer."'>";
                                        echo "<input type='hidden' name='qa_id' value='".$qa->id."'>";
                                    @endphp

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (B) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    @php
                                        $qb = \App\Question_ans::select('id','answer', 'sl_no')->where('question_id',$questions->id)->where('sl_no', 'B')->first();
                                        echo "<input class=form-control type='text' name='question_b' required value='".$qb->answer."'>";
                                        echo "<input type='hidden' name='qb_id' value='".$qb->id."'>";
                                    @endphp
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (C) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    @php
                                        $qc = \App\Question_ans::select('id','answer', 'sl_no')->where('question_id',$questions->id)->where('sl_no', 'C')->first();
                                        echo "<input class=form-control type='text' name='question_c' required value='".$qc->answer."'>";
                                        echo "<input type='hidden' name='qc_id' value='".$qc->id."'>";
                                    @endphp
                                </div>
                            </div>
                            
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (D) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    @php
                                        $qd = \App\Question_ans::select('id','answer', 'sl_no')->where('question_id',$questions->id)->where('sl_no', 'D')->first();
                                        echo "<input class=form-control type='text' name='question_d' required value='".$qd->answer."'>";
                                        echo "<input type='hidden' name='qd_id' value='".$qd->id."'>";
                                    @endphp
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">SBA Answer (E) (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    @php
                                        $qe = \App\Question_ans::select('id','answer', 'sl_no')->where('question_id',$questions->id)->where('sl_no', 'E')->first();
                                        echo "<input class=form-control type='text' name='question_e' required value='".$qe->answer."'>";
                                        echo "<input type='hidden' name='qe_id' value='".$qe->id."'>";
                                    @endphp
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Correct Answer (<i class="fa fa-asterisk ipd-star" style="font-size:11px;"></i>) </label>
                            <div class="col-md-6">
                                @if ($questions->correct_ans=='A') <label class='radio-inline'><input type='radio' name='correct_ans' value='A' checked > A </label>
                                @else <label class='radio-inline'><input type='radio' name='correct_ans' value='A' > A </label> @endif

                                @if ($questions->correct_ans=='B') <label class='radio-inline'><input type='radio' name='correct_ans' value='B' checked > B </label>
                                @else <label class='radio-inline'><input type='radio' name='correct_ans' value='B' > B </label> @endif

                                @if ($questions->correct_ans=='C') <label class='radio-inline'><input type='radio' name='correct_ans' value='C' checked > C </label>
                                @else <label class='radio-inline'><input type='radio' name='correct_ans' value='C' > C </label> @endif

                                @if ($questions->correct_ans=='D') <label class='radio-inline'><input type='radio' name='correct_ans' value='D' checked > D </label>
                                @else <label class='radio-inline'><input type='radio' name='correct_ans' value='D' > D </label> @endif

                                @if ($questions->correct_ans=='E') <label class='radio-inline'><input type='radio' name='correct_ans' value='E' checked > E </label>
                                @else <label class='radio-inline'><input type='radio' name='correct_ans' value='E' > E </label> @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Discussion</label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <textarea name="discussion" class="form-control">{{ $questions->discussion }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Reference</label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <textarea name="reference" class="form-control">{{ $questions->reference }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
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