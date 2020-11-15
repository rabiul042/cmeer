@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

{{--        @include('side_bar')--}}

        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Course Result</h3></div>

                <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-md-12 col-md-offset-0" style="">
                            <h4 style="color: orange;">Course Registration no. : <b>{{ $course_reg_no->reg_no }} </b></h4>
                            <hr>
                        </div>
                            @php $institute = (isset($course_reg_no->institute->name))?$course_reg_no->institute->name:'' @endphp

                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Exam Name</th>
                                            <th>Discipline</th>
                                            <th>Batch</th>
                                            @if($institute=='BSMMU')
                                                <th>Candidate</th>
                                            @endif
                                            <th>Session</th>
                                            <th>Year</th>
                                            <th>Obtained Mark</th>
                                            <th>Exam Highest</th>
                                            <th>Overall Position</th>
                                            <th>Discipline Position</th>
                                            <th>Batch Position</th>
                                            @if($institute=='BSMMU')
                                                <th>Candidate Position</th>
                                            @endif
                                            @if($institute=='BCPS')
                                                <th>Pass/Fail</th>
                                            @endif
                                            <th>Wrong Ans</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>{{ $result->exam_id }}</td>
                                                <td>{{ (isset($result->exam->name))?$result->exam->name:'' }}</td>
                                                <td>{{ (isset($result->subject->name))?$result->subject->name:'' }}</td>
                                                <td>{{ (isset($result->batch->name))?$result->batch->name:'' }}</td>
                                                @if($institute=='BSMMU')
                                                    <td>
                                                        {{ (($result->candidate_code=='A')?'Govt':(($result->candidate_code=='B')?'Private':(($result->candidate_code=='C')?'BSMMU':''))) }}
                                                    </td>
                                                @endif
                                                <td>{{ (isset($result->exam->sessions->name))?$result->exam->sessions->name:'' }}</td>
                                                <td>{{ (isset($result->exam->year))?$result->exam->year:'' }}</td>
                                                <td>{{ $result->obtained_mark }}</td>
                                                <td>{{ $result->exam_highest }}</td>
                                                <td>
                                                    @php $overall_position = $result->overall_position->count();  @endphp
                                                    {{$overall_position}}{{ ($overall_position == 1) ? 'st' : (($overall_position == 2) ? 'nd' : (($overall_position == 3) ? 'rd' : 'th'))  }}
                                                </td>
                                                <td>
                                                    @php $subject_position = $result->subject_position->count();  @endphp
                                                    {{$subject_position}}{{ ($subject_position == 1) ? 'st' : (($subject_position == 2) ? 'nd' : (($subject_position == 3) ? 'rd' : 'th'))  }}
                                                </td>
                                                <td>
                                                    @php $batch_position = $result->batch_position->count();  @endphp
                                                    {{$batch_position}}{{ ($batch_position == 1) ? 'st' : (($batch_position == 2) ? 'nd' : (($batch_position == 3) ? 'rd' : 'th'))  }}</td>
                                                @if($institute=='BSMMU')
                                                    <td>
                                                        @php $candidate_position = $result->candidate_position->count();  @endphp
                                                        {{$candidate_position}}{{ ($candidate_position == 1) ? 'st' : (($candidate_position == 2) ? 'nd' : (($candidate_position == 3) ? 'rd' : 'th'))  }}
                                                    </td>
                                                @endif
                                                @if($institute=='BCPS')
                                                    <td>{{ (($result->obtained_mark_decimal/100)>$result->exam->question_type->pass_mark)?'Pass':'Fail' }}</td>
                                                @endif
                                                <td>{{ $result->wrong_answers }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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
