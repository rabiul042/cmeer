@extends('layouts.app')

@section('content')
    <style>

        .page-breadcrumb {
            display: inline-block;
            float: left;
            padding: 8px;
            margin: 0;
            list-style: none;
        }
        .page-breadcrumb > li {
            display: inline-block;
        }
        .page-breadcrumb > li > a,
        .page-breadcrumb > li > span {
            color: #666;
            font-size: 14px;
            text-shadow: none;
        }
        .page-breadcrumb > li > i {
            color: #999;
            font-size: 14px;
            text-shadow: none;
        }
        .page-breadcrumb > li > i[class^="icon-"],
        .page-breadcrumb > li > i[class*="icon-"] {
            color: gray;
        }

    </style>


    <div class="container">



        <div class="row">

            <div class="col-md-9 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>{{ $exam->name }}</h3></div>

                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-success' }}" role="alert">
                                <p> {!! Session::get('message') !!} </p>
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-header"><span style="padding:9px;border-radius:50px;font-size:19px;font-weight:700;float:right;background-color: #915faa;color: white;">Remaining time : <span id="timer"></span></span><div hidden id="duration">{{ $duration }}</div></div>
                                <div class="portlet-body">
                                    {{--@foreach($exam->exam_questions as $exam_question)--}}
                                    <div id="question">
                                        @if(isset($exam_question->question->question_title))

                                            <input type="hidden" name="doctor_course_id" value="{{ $doctor_course->id }}">
                                            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                                            <input type="hidden" name="exam_question_id" value="{{ $exam_question->id }}">
                                            <input type="hidden" name="exam_question_type" value="{{ $exam_question->question->type }}">

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
                                    {{--@endforeach--}}
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

    <script src="{{ asset("js/alotimer.min.js") }}"></script>

    <script type="text/javascript">

        window.addEventListener('load',exam_time);

        function exam_time() {

            var duration = document.getElementById("duration").innerText;
            var span       = document.getElementById("timer"),
            timer      = new AloTimer(duration*1000+3000, ["hours", "minutes", "seconds"]), // 1 hr
            intervalCb = function () {
                if (!timer.hasFinished) {
                    span.innerText = timer.toString();
                } else {
                    span.innerText = "Exam time is over!!!";
                    clearInterval(interval);
                    submit_answer_and_terminate_exam();
                    document.getElementById("id_button_submit").setAttribute('disabled','disabled');
                    document.getElementById("id_button_submit").innerText = "Finished";
                }
            },
            interval   = setInterval(intervalCb, 1000);

        }

        function submit_answer()
        {
            var doctor_course_id = $("[name='doctor_course_id']").val();
            var exam_id = $("[name='exam_id']").val();
            var exam_question_id = $("[name='exam_question_id']").val();
            var exam_question_type = $("[name='exam_question_type']").val();

            if(exam_question_type == 1)
            {
                var ans_a = $("[name='A']:checked").val();
                var ans_b = $("[name='B']:checked").val();
                var ans_c = $("[name='C']:checked").val();
                var ans_d = $("[name='D']:checked").val();
                var ans_e = $("[name='E']:checked").val();

                console.log(exam_id + "_" + exam_question_id + " = " +ans_a+" "+ans_b+" "+ans_c+" "+ans_d+" "+ans_e);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/submit-answer',
                    dataType: 'HTML',
                    data: { doctor_course_id:doctor_course_id, exam_id:exam_id, exam_question_id : exam_question_id, ans_a : ans_a, ans_b : ans_b, ans_c : ans_c, ans_d : ans_d, ans_e : ans_e },
                    success: function( data ) {
                        var data = JSON.parse(data);
                        $('#question').html('');
                        $('#question').html(data['question']);
                        if(data['redirect'])
                        {
                            var loc = window.location;
                            window.location = loc.protocol+"//"+loc.hostname+":"+loc.port+data['redirect'];
                        }
                    }
                });

            }
            else if(exam_question_type == 2)
            {
                var ans_sba = $("[name='ans_sba']:checked").val();

                console.log(exam_id + "_" + exam_question_id + " = " +ans_sba);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/submit-answer',
                    dataType: 'HTML',
                    data: { doctor_course_id:doctor_course_id, exam_id:exam_id, exam_question_id : exam_question_id , ans_sba : ans_sba },
                    success: function( data ) {
                        var data = JSON.parse(data);
                        $('#question').html('');
                        $('#question').html(data['question']);
                        if(data['redirect'])
                        {
                            var loc = window.location;
                            window.location = loc.protocol+"//"+loc.hostname+":"+loc.port+data['redirect'];

                        }

                    }
                });

            }



        }

        function submit_answer_and_terminate_exam() {
            var doctor_course_id = $("[name='doctor_course_id']").val();
            var exam_id = $("[name='exam_id']").val();
            var exam_question_id = $("[name='exam_question_id']").val();
            var exam_question_type = $("[name='exam_question_type']").val();

            if (exam_question_type == 1) {
                var ans_a = $("[name='A']:checked").val();
                var ans_b = $("[name='B']:checked").val();
                var ans_c = $("[name='C']:checked").val();
                var ans_d = $("[name='D']:checked").val();
                var ans_e = $("[name='E']:checked").val();

                console.log(exam_id + "_" + exam_question_id + " = " + ans_a + " " + ans_b + " " + ans_c + " " + ans_d + " " + ans_e);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/submit-answer-and-terminate-exam',
                    dataType: 'HTML',
                    data: {
                        doctor_course_id: doctor_course_id,
                        exam_id: exam_id,
                        exam_question_id: exam_question_id,
                        ans_a: ans_a,
                        ans_b: ans_b,
                        ans_c: ans_c,
                        ans_d: ans_d,
                        ans_e: ans_e
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#question').html('');
                        $('#question').html(data['question']);
                        if (data['redirect']) {
                            var loc = window.location;
                            window.location = loc.protocol + "//" + loc.hostname + ":" + loc.port + data['redirect'];
                        }
                    }
                });

            } else if (exam_question_type == 2) {
                var ans_sba = $("[name='ans_sba']:checked").val();

                console.log(exam_id + "_" + exam_question_id + " = " + ans_sba);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/submit-answer-and-terminate-exam',
                    dataType: 'HTML',
                    data: {
                        doctor_course_id: doctor_course_id,
                        exam_id: exam_id,
                        exam_question_id: exam_question_id,
                        ans_sba: ans_sba
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#question').html('');
                        $('#question').html(data['question']);
                        if (data['redirect']) {
                            var loc = window.location;
                            window.location = loc.protocol + "//" + loc.hostname + ":" + loc.port + data['redirect'];

                        }

                    }
                });

            }

        }

        function skip_question() {
            var doctor_course_id = $("[name='doctor_course_id']").val();
            var exam_id = $("[name='exam_id']").val();
            var exam_question_id = $("[name='exam_question_id']").val();
            var exam_question_type = $("[name='exam_question_type']").val();

            if (exam_question_type == 1) {
                var ans_a = $("[name='A']:checked").val();
                var ans_b = $("[name='B']:checked").val();
                var ans_c = $("[name='C']:checked").val();
                var ans_d = $("[name='D']:checked").val();
                var ans_e = $("[name='E']:checked").val();

                console.log(exam_id + "_" + exam_question_id + " = " + ans_a + " " + ans_b + " " + ans_c + " " + ans_d + " " + ans_e);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/skip-question',
                    dataType: 'HTML',
                    data: {
                        doctor_course_id: doctor_course_id,
                        exam_id: exam_id,
                        exam_question_id: exam_question_id,
                        ans_a: ans_a,
                        ans_b: ans_b,
                        ans_c: ans_c,
                        ans_d: ans_d,
                        ans_e: ans_e
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#question').html('');
                        $('#question').html(data['question']);
                        if (data['redirect']) {
                            var loc = window.location;
                            window.location = loc.protocol + "//" + loc.hostname + ":" + loc.port + data['redirect'];
                        }
                    }
                });

            } else if (exam_question_type == 2) {
                var ans_sba = $("[name='ans_sba']:checked").val();

                console.log(exam_id + "_" + exam_question_id + " = " + ans_sba);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/skip-question',
                    dataType: 'HTML',
                    data: {
                        doctor_course_id: doctor_course_id,
                        exam_id: exam_id,
                        exam_question_id: exam_question_id,
                        ans_sba: ans_sba
                    },
                    success: function (data) {
                        var data = JSON.parse(data);
                        $('#question').html('');
                        $('#question').html(data['question']);
                        if (data['redirect']) {
                            var loc = window.location;
                            window.location = loc.protocol + "//" + loc.hostname + ":" + loc.port + data['redirect'];

                        }

                    }
                });

            }

        }

    </script>


@endsection
