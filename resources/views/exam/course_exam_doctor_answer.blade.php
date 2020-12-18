@extends('layouts.app')

@section('content')

    <div class="container">


        <div class="row">

            <div class="col-md-9 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>{{ $exam->name }}</h3></div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <table class="table table-bordered" style="table-layout: auto;">
                                        <tr><th>Questions</th><th>Your Answer</th><th>Correct Answer</th><th>Remark</th></tr>
                                        @foreach($exam->exam_questions as $exam_question)
                                            @php $i=0; @endphp
                                            <div id="question">
                                                @if(isset($exam_question->question->question_title))

                                                    <tr>
                                                        <td colspan="4"><h4 class='modal-title' id='myModalLabel'>{!! '('.($exam->exam_questions->search($exam_question) + 1).' of '.$exam->exam_questions->count().' ) '.$exam_question->question->question_title !!}</h4></td>
                                                    </tr>

                                                    @if($exam_question->question->type == "1")
                                                        @foreach($exam_question->question->question_answers as $k=>$answer)
                                                            @if($k<session('stamp'))
                                                                @if($given_answers[$exam_question->question->id][$answer->sl_no] == $answer->correct_ans )
                                                                    <tr>
                                                                        <td>
                                                                            {!! isset($answer->answer)? $answer->answer:'' !!}
                                                                        </td>

                                                                        <td>
                                                                            <div class="radio" style="overflow:hidden;width:30px;">
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no }}" value='T' {{ ( isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id][$answer->sl_no] == "T" ) ? "checked":'' }} > T       </label>
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no }}" value='F' {{ ( isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id][$answer->sl_no] == "F" ) ? "checked":'' }} > F       </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="radio" style="overflow:hidden;width:30px;">
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no.$answer->sl_no }}" value='T' {{ ( $answer->correct_ans == "T" ) ? "checked":'' }} > T       </label>
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no.$answer->sl_no }}" value='F' {{ ( $answer->correct_ans == "F" ) ? "checked":'' }} > F       </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="radio" style="overflow:hidden;">
                                                                                <label style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>
                                                                            {!! isset($answer->answer)? $answer->answer:'' !!}
                                                                        </td>

                                                                        <td>
                                                                            <div class="radio" style="overflow:hidden;width:30px;">
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no }}" value='T' {{ ( isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id][$answer->sl_no] == "T" ) ? "checked":'' }} > T       </label>
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no }}" value='F' {{ ( isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id][$answer->sl_no] == "F" ) ? "checked":'' }} > F       </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="radio" style="overflow:hidden;width:30px;">
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no.$answer->sl_no }}" value='T' {{ ( $answer->correct_ans == "T" ) ? "checked":'' }} > T       </label>
                                                                                <label><input type='radio' name="{{ $exam_question->question->id.$answer->sl_no.$answer->sl_no }}" value='F' {{ ( $answer->correct_ans == "F" ) ? "checked":'' }} > F       </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="radio" style="overflow:hidden;">
                                                                                @if($given_answers[$exam_question->question->id][$answer->sl_no] != '.' && $given_answers[$exam_question->question->id][$answer->sl_no] != '')
                                                                                <label style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($exam_question->question->question_answers as $k=>$answer)
                                                            @if($k<session('stamp'))
                                                                <tr>
                                                                    <td>
                                                                        {!! isset($answer->answer)? $answer->answer:'' !!}
                                                                    </td>
                                                                    <td>
                                                                        <div class="radio" style="overflow:hidden;width:30px;">
                                                                            <label><input type='radio' name='ans_sba{{$exam_question->question->id}}1' value='{{ $answer->sl_no }}1' {{ ($given_answers[$exam_question->question->id] == $answer->sl_no) ? "checked":'' }} >{{ $answer->sl_no }}</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="radio" style="overflow:hidden;width:30px;">
                                                                            <label><input type='radio' name='ans_sba{{$exam_question->question->id}}2' value='{{ $answer->sl_no }}2' {{ ( $answer->correct_ans == $answer->sl_no ) ? "checked":'' }} >{{ $answer->sl_no }}</label>
                                                                        </div>
                                                                    </td>
                                                                    @if($given_answers[$exam_question->question->id] == $answer->correct_ans && $i++==0)
                                                                        <td rowspan="5">
                                                                            <div class="radio" style="overflow:hidden;">
                                                                                <label style="color:green;"><i class="fa fa-check" aria-hidden="true"></i></label>
                                                                            </div>
                                                                        </td>
                                                                    @elseif($given_answers[$exam_question->question->id] != $answer->correct_ans && $given_answers[$exam_question->question->id] != '.' && $given_answers[$exam_question->question->id] != '' && $i++==0)
                                                                        <td rowspan="5">
                                                                            <div class="radio" style="overflow:hidden;">
                                                                                <label style="color:red;"><i class="fa fa-times" aria-hidden="true"></i></label>
                                                                            </div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        {{--<tr>
                                                            <td colspan="4">
                                                                <label class='radio-inline'><input type='radio' name='ans_sba{{$exam_question->question->id}}' value='A' {{ (isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id] == "A") ? "checked":'' }} > A </label>
                                                                <label class='radio-inline'><input type='radio' name='ans_sba{{$exam_question->question->id}}' value='B' {{ (isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id] == "B") ? "checked":'' }}> B </label>
                                                                <label class='radio-inline'><input type='radio' name='ans_sba{{$exam_question->question->id}}' value='C' {{ (isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id] == "C") ? "checked":'' }}> C </label>
                                                                <label class='radio-inline'><input type='radio' name='ans_sba{{$exam_question->question->id}}' value='D' {{ (isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id] == "D") ? "checked":'' }}> D </label>
                                                                <label class='radio-inline'><input type='radio' name='ans_sba{{$exam_question->question->id}}' value='E' {{ (isset($given_answers[$exam_question->question->id]) && $given_answers[$exam_question->question->id] == "E") ? "checked":'' }}> E </label>
                                                            </td>
                                                        </tr>--}}
                                                    @endif
                                                    <tr>
                                                        <td colspan="4">
                                                            <button style="background-color: #0e86ce;color: white;border-color:#0e86ce;" data-toggle='modal' data-target='#modal_batch_details_{{ $exam_question->question->id }}1' >Reference</button><button style="margin-left:10px;background-color: #3e8f3e;color: white;border-color:#3e8f3e;" data-toggle='modal' data-target='#modal_batch_details_{{ $exam_question->question->id }}2'>Discussion</button> <!--<button style="margin-left:10px;background-color: #915faa;color: white;border-color:#915faa;" data-toggle='modal' data-target='#modal_batch_details_{{ $exam_question->question->id }}3'>Video Link</button>-->

                                                            {{--<span class="btn btn-sm btn-primary" data-toggle='modal' data-target='#modal_batch_details_{{ $exam_question->question->id }}' style="line-height:32px;">Question Discussion</span>--}}
                                                            <div class='modal fade' id='modal_batch_details_{{ $exam_question->question->id }}1' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                                                    <div class='modal-content'>

                                                                        <div class='modal-header'>
                                                                            References : {!! $exam_question->question->question_title !!}
                                                                        </div>
                                                                        <div class='modal-body'>
                                                                            {!! $exam_question->question->reference !!}
                                                                        </div>

                                                                        <div class='modal-footer'>
                                                                            <button type='button' class='btn btn-sm bg-red' data-dismiss='modal'>Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class='modal fade' id='modal_batch_details_{{ $exam_question->question->id }}2' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                                                    <div class='modal-content'>

                                                                        <div class='modal-header'>
                                                                            Discussion : {!! $exam_question->question->question_title !!}
                                                                        </div>
                                                                        <div class='modal-body'>
                                                                            {!! $exam_question->question->discussion !!}

                                                                        </div>

                                                                        <div class='modal-footer'>
                                                                            <button type='button' class='btn btn-sm bg-red' data-dismiss='modal'>Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class='modal fade' id='modal_batch_details_{{ $exam_question->question->id }}3' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                                                <div class='modal-dialog modal-dialog-centered' role='document'>
                                                                    <div class='modal-content'>

                                                                        <div class='modal-header'>
                                                                            Video Link : {!! $exam_question->question->question_title !!}
                                                                        </div>
                                                                        <div class='modal-body'>
                                                                            {!! $exam_question->question->video_link !!}

                                                                        </div>

                                                                        <div class='modal-footer'>
                                                                            <button type='button' class='btn btn-sm bg-red' data-dismiss='modal'>Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>

                                                @endif
                                            </div>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection

@section('js')

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            $('*').click(function(e){e.preventDefault();});

        })
    </script>

@endsection