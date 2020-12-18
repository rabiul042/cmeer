<div id="question">
    @if(isset($exam_question->question->question_title))

        <input type="hidden" name="doctor_course_id" value="{{ $doctor_course->id }}">
        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="exam_question_id" value="{{ $exam_question->id }}">
        <input type="hidden" name="exam_question_type" value="{{ $exam_question->question->type }}">

        <div>
            @php //echo "<pre>"; print_r($exam_question); @endphp
        </div>


        <div>
            <h4 class='modal-title' id='myModalLabel'>{!! '('.($serial_no).' of '.$exam->exam_questions->count().' ) '.$exam_question->question->question_title !!}</h4>
        </div>

        <table class="table table-borderless" style="table-layout: auto;">
            @if($exam_question->question->type == "1")
                @foreach($exam_question->question->question_answers as $k=>$answer)
                    @if($k<session('stamp'))
                        <tr>
                            <td>
                                {!! isset($answer->answer)? $answer->answer:'' !!}
                            </td>

                            <td style="width: 99px;">
                                <label class='radio-inline'><input type='radio' name="{{ $answer->sl_no }}" value='T'  > T </label>
                                <label class='radio-inline'><input type='radio' name="{{ $answer->sl_no }}" value='F'  > F </label>
                            </td>

                        </tr>
                    @endif
                @endforeach
            @else
                @foreach($exam_question->question->question_answers as $k=>$answer)
                    @if($k<session('stamp'))
                        <tr>
                            <td>
                                {!! isset($answer->answer)? $answer->answer:'' !!}
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td>
                        <label class='radio-inline'><input type='radio' name='ans_sba' value='A' > A </label>
                        <label class='radio-inline'><input type='radio' name='ans_sba' value='B' > B </label>
                        <label class='radio-inline'><input type='radio' name='ans_sba' value='C' > C </label>
                        <label class='radio-inline'><input type='radio' name='ans_sba' value='D' > D </label>
                        @if(session('stamp')==5)
                        <label class='radio-inline'><input type='radio' name='ans_sba' value='E' > E </label>
                        @endif
                    </td>
                </tr>
            @endif
        </table>

        <div style="float:right;">
            <button id="id_button_skip" class='btn btn-success' onclick='skip_question()' {{ ($exam_finish=='Finished') ? 'disabled' : '' }}>Skip</button>
            <button id="id_button_submit" class='btn btn-success' onclick='submit_answer()' {{ ($exam_finish=='Finished') ? 'disabled' : '' }}>{{ $exam_finish }}</button>
        </div>
    @endif
</div>