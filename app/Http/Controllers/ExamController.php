<?php

namespace App\Http\Controllers;

use App\BcpsFaculty;
use App\BmDoctors;
use App\DoctorAnswers;
use App\DoctorExam;
use App\DoctorsCourses;
use App\Exam_question;
use App\Exam_topic;
//use App\courseExam;
use App\QuestionTypes;
use App\Result;
use Illuminate\Http\Request;
use App\Exam;
use App\ExamQuestion;
use Session;
use Auth;
use Carbon\Carbon;

class ExamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function exam($doctor_course_id,$exam_id)
    {
        $doctor_exam_status = DoctorExam::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->value('status');
        if(isset($doctor_exam_status) && $doctor_exam_status == "Completed" && Result::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->first())
        {
            Session::flash('class', 'alert-danger');
            session()->flash('message','Dear doctor you have already taken part in this exam !!! ');
            return redirect('doctor-course-online-exam/'.$doctor_course_id);
        }
        else
        {
            $data['exam'] = Exam::find($exam_id);
// dd($data['exam']->exam_questions);
            $data['doctor_course'] = DoctorsCourses::where(['id'=>$doctor_course_id])->first();

            if($data['doctor_course']->institute_id==7){
                session(['stamp'=>4]);
            }else{
                session(['stamp'=>5]);
            }

            if($data['exam']->exam_questions->count() == ( $data['exam']->question_type->mcq_number + $data['exam']->question_type->sba_number ))
            {
                if(DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id,'status'=>"Running"])->first())
                {

                    if($this->check_exam_completion($doctor_course_id,$exam_id))
                    {
                        Session::flash('class', 'alert-danger');
                        session()->flash('message','Dear doctor you did not completed the exam in time !!!<br><br> Please continue to your incomplete exam <a href="'.url('continue-doctor-exam/'.$doctor_course_id.'/'.$exam_id).'" class="btn btn-xs btn-success">Click Here</a> <br> Or <br>To start the exam again <a href="'.url('/doctor-batch-exam-reopen/'.$doctor_course_id.'/'.$exam_id).'" class="btn btn-xs btn-info">Click Here</a>');
                        return redirect('doctor-course-online-exam/'.$doctor_course_id);
                    }

                    $doctor_answered_last_question = DoctorAnswers::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->orderBy('id','desc')->first();
                    if(isset($doctor_answered_last_question))
                    {

                        $exam_question = Exam_question::find($doctor_answered_last_question->exam_question_id);
                        $exam = Exam::find($exam_id);

                        $doctor_answers = DoctorAnswers::where(['exam_id' => $exam_id, 'doctor_course_id' => $doctor_course_id])->get();

                        $data['doctor_course'] = $doctor_course = DoctorsCourses::where('id', $doctor_course_id)->first();
                        $data['exam'] = $exam;
                        if ($doctor_answers->count() == $exam->exam_questions->count() - 1) {
                            $exam_question_ids = DoctorAnswers::where(['exam_id' => $exam->id, 'doctor_course_id' => $doctor_course_id])->pluck('exam_question_id')->toArray();
                            $exam_questions = Exam_question::whereIn('id', $exam_question_ids)->get();
                            $data['exam_question'] = $exam->exam_questions->diff($exam_questions)[0];
                            $data['exam_finish'] = "Finish";
                            $data['serial_no'] = $exam->exam_questions->search($exam->exam_questions->diff($exam_questions)[0]) + 1;

                            $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");

                            $diff_in_seconds = $this->get_difference_in_exam_time($doctor_course_id,$exam_id);

                            $data['duration'] = $data['exam']->question_type->duration - $diff_in_seconds;

                            return view('exam.exam', $data);

                        } else if ($doctor_answers->count() == $exam->exam_questions->count()) {
                            $data['exam_question'] = $exam->exam_questions[$exam->exam_questions->search($exam_question)];
                            $data['exam_finish'] = "Finished";
                            $data['serial_no'] = $exam->exam_questions->search($exam_question) + 1;
                            $this->update_exam_status($doctor_course_id,$exam_id,$status="Completed");
                            return view('exam.exam', $data);


                        } else {

                            if ($exam->exam_questions->search($exam_question) < $exam->exam_questions->count() - 1) {
                                $exam_questions = Exam_question::where(['exam_id' => $exam->id])->where('id', '>', $exam_question->id)->get();
                                $doctor_answered_exam_question_ids = DoctorAnswers::where(['exam_id' => $exam->id, 'doctor_course_id' => $doctor_course_id])->where('exam_question_id', '>', $exam_question->id)->pluck('exam_question_id')->toArray();
                                $doctor_given_exam_questions = Exam_question::where(['exam_id' => $exam->id])->whereIn('id', $doctor_answered_exam_question_ids)->get();
                                $rest_unanswered_questions = $exam_questions->diff($doctor_given_exam_questions);

                                if (isset($rest_unanswered_questions[0])) {
                                    $data['exam_question'] = $rest_unanswered_questions[0];
                                } else {
                                    $exam_question_ids = DoctorAnswers::where(['exam_id' => $exam->id, 'doctor_course_id' => $doctor_course_id])->pluck('exam_question_id')->toArray();
                                    $exam_questions = Exam_question::whereIn('id', $exam_question_ids)->get();
                                    $rest_unanswered_questions = $exam->exam_questions->diff($exam_questions);

                                    $data['exam_question'] = $rest_unanswered_questions[0];
                                }

                            } else if ($exam->exam_questions->search($exam_question) == $exam->exam_questions->count() - 1) {

                                $exam_question_ids = DoctorAnswers::where(['exam_id' => $exam->id, 'doctor_course_id' => $doctor_course_id])->pluck('exam_question_id')->toArray();
                                $exam_questions = Exam_question::whereIn('id', $exam_question_ids)->get();
                                $rest_unanswered_questions = $exam->exam_questions->diff($exam_questions);

                                $data['exam_question'] = $rest_unanswered_questions[0];

                            }

                            $data['duration'] = $data['exam']->question_type->duration;

                            $data['exam_finish'] = "Next";
                            $data['serial_no'] = $exam->exam_questions->search($rest_unanswered_questions[0]) + 1;

                            $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");

                            $diff_in_seconds = $this->get_difference_in_exam_time($doctor_course_id,$exam_id);

                            $data['duration'] = $data['exam']->question_type->duration - $diff_in_seconds;

                            return view('exam.exam', $data);

                        }
                    }
                    else
                    {
                        $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");

                        $diff_in_seconds = $this->get_difference_in_exam_time($doctor_course_id,$exam_id);

                        $data['duration'] = $data['exam']->question_type->duration - $diff_in_seconds;

                        $data['exam_question'] = $data['exam']->exam_questions[0];
                        $data['serial_no'] = 1;

                        $data['exam_finish'] = "Next";

                        return view('exam.exam', $data);

                    }

                }
                else
                {
                    $data['duration'] = $data['exam']->question_type->duration;
                    $data['exam_question'] = $data['exam']->exam_questions[0];
                    $data['serial_no'] = 1;
                    $data['exam_finish'] = "Next";

                    if (date_default_timezone_get()) {
                        $previous_time_zone = date_default_timezone_get();
                        date_default_timezone_set('Asia/Dhaka');
                        $time = date('Y-m-d H:i:s',time());
                        DoctorExam::insert(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id,'start_time'=>$time,'updated_time'=>$time,'status'=>"Running"]);
                        date_default_timezone_set($previous_time_zone);

                    }

                    return view('exam.exam', $data);

                }


            }
            else
            {
                return abort(404);
            }
        }

    }

    public function continue_doctor_exam($doctor_course_id,$exam_id)
    {
        DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->update(['status'=>"Running"]);

        if (date_default_timezone_get()) {
            $previous_time_zone = date_default_timezone_get();
            date_default_timezone_set('Asia/Dhaka');
            $a = strtotime(DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->value('updated_time'));
            $b = strtotime(DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->value('start_time'));
            $c = time();
            $d = $c - ($a-$b);
            DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->update(['start_time'=>date("Y-m-d H:i:s",$d)]);
            DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->update(['updated_time'=>date("Y-m-d H:i:s",$c)]);
            date_default_timezone_set($previous_time_zone);
        }

        return redirect('doctor-course-exam/'.$doctor_course_id.'/'.$exam_id);

    }

    public function check_exam_completion($doctor_course_id,$exam_id)
    {
        $exam = Exam::where(['id'=>$exam_id])->first();

        if (date_default_timezone_get()) {
            $previous_time_zone = date_default_timezone_get();
            date_default_timezone_set('Asia/Dhaka');
            $a = time();
            $b = strtotime(DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->value('start_time'));
            $diff_in_seconds = ($a-$b);
            date_default_timezone_set($previous_time_zone);
        }
        if(isset($exam) && $exam->question_type->duration < $diff_in_seconds){
            return true;
        }
        else
        {
            return false;
        }
    }

    public function update_exam_status($doctor_course_id,$exam_id,$status)
    {
        if (date_default_timezone_get()) {
            $previous_time_zone = date_default_timezone_get();
            date_default_timezone_set('Asia/Dhaka');
            $time = date('Y-m-d H:i:s',time());
            DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->update(['updated_time'=>$time,'status'=>$status]);
            date_default_timezone_set($previous_time_zone);

        }

    }

    public function get_difference_in_exam_time($doctor_course_id,$exam_id)
    {
        if (date_default_timezone_get()) {
            $previous_time_zone = date_default_timezone_get();
            date_default_timezone_set('Asia/Dhaka');
            $a = strtotime(DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->value('updated_time'));
            $b = strtotime(DoctorExam::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->value('start_time'));
            date_default_timezone_set($previous_time_zone);
        }

        return $diff_in_seconds = ($a-$b);
    }

    public function course_exam_result_submit($doctor_course_id,$exam_id)
    {
        $exam = Exam::where('id',$exam_id)->first();
        $doctor_course = DoctorsCourses::where('id',$doctor_course_id)->first();

        $correct_mark = 0;
        $negative_mark = 0;
        $wrong_answer =0;
        $mcq_mark = $exam->question_type->mcq_mark/5;
        $sba_mark = $exam->question_type->sba_mark;
        $mcq_negative_mark = $exam->question_type->mcq_negative_mark;
        $sba_negative_mark = $exam->question_type->sba_negative_mark;
        $obtained_mark = 0;

        $doctor_answers = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course->id])->get();
// dd($doctor_answers->exam_question->question->type);


        foreach ($doctor_answers as $doctor_answer)
        {
            if(isset($doctor_answer->exam_question->question->type) && $doctor_answer->exam_question->question->type == 1)
            {
                foreach($doctor_answer->exam_question->question->question_answers as $question_answer)
                {
                    if($question_answer->sl_no == "A" ){
                        if(substr($doctor_answer->answer,0,1) == $question_answer->correct_ans){
                            $correct_mark += $mcq_mark;
                        }
                        else if(substr($doctor_answer->answer,0,1) != ".")
                        {
                            $negative_mark += $mcq_negative_mark;
                            $wrong_answer++;
                        }
                    }
                    else if($question_answer->sl_no == "B" ){
                        if(substr($doctor_answer->answer,1,1) == $question_answer->correct_ans){
                            $correct_mark += $mcq_mark;
                        }
                        else if(substr($doctor_answer->answer,1,1) != ".")
                        {
                            $negative_mark += $mcq_negative_mark;
                            $wrong_answer++;
                        }
                    }
                    else if($question_answer->sl_no == "C" ){
                        if(substr($doctor_answer->answer,2,1) == $question_answer->correct_ans){
                            $correct_mark += $mcq_mark;
                        }
                        else if(substr($doctor_answer->answer,2,1) != ".")
                        {
                            $negative_mark += $mcq_negative_mark;
                            $wrong_answer++;
                        }
                    }
                    else if($question_answer->sl_no == "D" ){
                        if(substr($doctor_answer->answer,3,1) == $question_answer->correct_ans){
                            $correct_mark += $mcq_mark;
                        }
                        else if(substr($doctor_answer->answer,3,1) != ".")
                        {
                            $negative_mark += $mcq_negative_mark;
                            $wrong_answer++;
                        }
                    }
                    else if($question_answer->sl_no == "E" ){
                        if(substr($doctor_answer->answer,4,1) == $question_answer->correct_ans){
                            $correct_mark += $mcq_mark;
                        }
                        else if(substr($doctor_answer->answer,4,1) != ".")
                        {
                            $negative_mark += $mcq_negative_mark;
                            $wrong_answer++;
                        }
                    }


                }

            }
            else if(isset($doctor_answer->exam_question->question->type) && $doctor_answer->exam_question->question->type == 2)
            {
                if($doctor_answer->answer == $doctor_answer->exam_question->question->question_answers[0]->correct_ans){
                    $correct_mark += $sba_mark;
                }
                else if($doctor_answer->answer != ".")
                {
                    $negative_mark += $sba_negative_mark;
                    $wrong_answer++;
                }

            }

        }

        $obtained_mark = $correct_mark - $negative_mark;
        echo 'obtained = '.$obtained_mark.' , correct_mark = '.$correct_mark.' negative_mark = '.$negative_mark;

        $result = Result::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course->id])->first();

        if(!isset($result))
        {
            Result::insert([
                'exam_id'=>$exam->id,
                'doctor_course_id'=>$doctor_course->id,
                'subject_id'=>$doctor_course->subject_id,
                'batch_id'=>$doctor_course->batch_id,
                'correct_mark'=>$correct_mark,
                'negative_mark'=>$negative_mark,
                'obtained_mark'=>$obtained_mark,
                'obtained_mark_decimal'=>$obtained_mark*10,
                'wrong_answers'=>$wrong_answer,
            ]);

        }
        elseif(isset($result))
        {
            Result::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course->id])->update([
                'exam_id'=>$exam->id,
                'doctor_course_id'=>$doctor_course->id,
                'subject_id'=>$doctor_course->subject_id,
                'batch_id'=>$doctor_course->batch_id,
                'correct_mark'=>$correct_mark,
                'negative_mark'=>$negative_mark,
                'obtained_mark'=>$obtained_mark,
                'obtained_mark_decimal'=>$obtained_mark*10,
                'wrong_answers'=>$wrong_answer,
            ]);
        }

        $this->update_exam_status($doctor_course_id,$exam_id,$status="Completed");

        return redirect('course-exam-result/'.$doctor_course->id.'/'.$exam->id);

    }
    /*}*/

    public function course_exam_result($doctor_course_id,$exam_id)
    {

        $data['course_exam_result'] = Result::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->first();

        if(isset($data['course_exam_result']))
        {
            $data['result'] = $this->result($doctor_course_id,$exam_id);
            return view('exam.course_exam_result', $data);

        }
        else
        {
            Session::flash('class', 'alert-danger');
            session()->flash('message','Dear doctor you did not take part this exam yet!!!');
            return redirect('doctor-course-online-exam/'.$doctor_course_id);
        }
        //echo "<pre>";print_r($data['course_exam_result']);exit;


    }

    public function course_exam_doctor_answer($doctor_course_id,$exam_id)
    {
        $data['exam'] = Exam::find($exam_id);

        $exam = Exam::find($exam_id);

        $doctor_course = DoctorsCourses::where('id',$doctor_course_id)->first();

        $doctor_answers = DoctorAnswers::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->get();
        $doctor_exam = DoctorExam::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->first();

        //echo "<pre>";print_r($exam->exam_questions[41]->question->question_answers);exit;
        
        if(isset($doctor_exam) && $doctor_exam->status == "Completed"){

            if($doctor_course->institute_id==7){
                session(['stamp'=>4]);
            }else{
                session(['stamp'=>5]);
            }

            $given_answers = array();

            foreach ($doctor_answers as $doctor_answer)
            {   
                if(isset($doctor_answer->exam_question->question->type) && $doctor_answer->exam_question->question->type == 1)
                {
                    foreach ($doctor_answer->exam_question->question->question_answers as $question_answer)
                    {
                        if($question_answer->sl_no == "A")$given_answers[$doctor_answer->exam_question->question->id][$question_answer->sl_no] = substr($doctor_answer->answer,0,1);
                        else if($question_answer->sl_no == "B")$given_answers[$doctor_answer->exam_question->question->id][$question_answer->sl_no] = substr($doctor_answer->answer,1,1);
                        else if($question_answer->sl_no == "C")$given_answers[$doctor_answer->exam_question->question->id][$question_answer->sl_no] = substr($doctor_answer->answer,2,1);
                        else if($question_answer->sl_no == "D")$given_answers[$doctor_answer->exam_question->question->id][$question_answer->sl_no] = substr($doctor_answer->answer,3,1);
                        else if($question_answer->sl_no == "E")$given_answers[$doctor_answer->exam_question->question->id][$question_answer->sl_no] = substr($doctor_answer->answer,4,1);

                    }

                }
                else
                {
                    if(isset($doctor_answer->exam_question->question->id))$given_answers[$doctor_answer->exam_question->question->id] = $doctor_answer->answer;
                }

            }

            foreach ($exam->exam_questions as $exam_question)
            {
                if(isset($exam_question->question->question_title))
                {
                    if($exam_question->question->type == "1")
                    {
                        foreach($exam_question->question->question_answers as $k=>$answer)
                        {
                            if(!isset($given_answers[$exam_question->question->id][$answer->sl_no]))
                            {
                                $given_answers[$exam_question->question->id][$answer->sl_no] = '.';
                            }

                        }
                    }
                    else
                    {
                        if(!isset($given_answers[$exam_question->question->id]))
                        {
                            $given_answers[$exam_question->question->id] = '.';
                        }
                    }
                }

            }
            
            //echo "<pre>";print_r($given_answers[$exam->exam_questions[41]->question->id]);exit;

            //echo "<pre>";print_r($given_answers);exit;
            $data['given_answers'] = $given_answers;

            return view('exam.course_exam_doctor_answer', $data);


        }
        else
        {

            Session::flash('class', 'alert-danger');
            session()->flash('message','Dear doctor you did not completed the exam or did not take part this exam yet!!!');
            return redirect('doctor-course-online-exam/'.$doctor_course_id);

        }



    }

    public function doctor_batch_exam_reopen($doctor_course_id,$exam_id)
    {
        DoctorExam::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->delete();
        DoctorAnswers::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->delete();
        Result::where(['doctor_course_id'=>$doctor_course_id,'exam_id'=>$exam_id])->delete();

        Session::flash('class', 'alert-success');
        session()->flash('message','Exam Reopened And Started Successfully....');

        return redirect('doctor-course-exam/'.$doctor_course_id.'/'.$exam_id);

        //echo "Doctor Exam Reopened Successfully. ";
    }

    public function result($doctor_course_id,$exam_id)
    {
        $result = array();
        $exam = Exam::find($exam_id);
        $doctor_course = DoctorsCourses::find($doctor_course_id);
        $doctor_course_result = Result::where(['doctor_course_id'=>$doctor_course->id,'exam_id'=>$exam_id])->first();
        $result['highest_mark']  = Result::where('exam_id' , $exam_id)->orderBy('obtained_mark','desc')->value('obtained_mark');
        $result['overall_position'] = $this->overall_position($exam->id,$doctor_course_result->id);
        $result['subject_position'] = $this->subject_position($exam->id,$doctor_course->subject_id,$doctor_course_result->id);
        $result['batch_position'] = $this->batch_position($exam->id,$doctor_course->batch_id,$doctor_course_result->id);

        //$result = $this->view_doctor_result($doctor_course_id,$exam_id);

        return $result;

    }

    function overall_position($exam_id,$doctor_course_result_id)
    {
        $results = Result::where(['exam_id' => $exam_id])->orderBy('obtained_mark', 'desc')->get();
        $doctor_course_result = Result::where(['id' => $doctor_course_result_id])->first();

        foreach ($results as $k => $row) {

            if ($doctor_course_result->obtained_mark == $row->obtained_mark) {

                $p = ($k + 1);
                $th = ($p == 1) ? 'st' : (($p == 2) ? 'nd' : (($p == 3) ? 'rd' : 'th'));
                $pos = $p . $th;
                break;

            }

        }

        return $pos;
    }

    function subject_position($exam_id,$subject_id,$doctor_course_result_id)
    {
        $results = Result::where(['exam_id' => $exam_id,'subject_id'=>$subject_id])->orderBy('obtained_mark', 'desc')->get();
        $doctor_course_result = Result::where(['id' => $doctor_course_result_id])->first();


        $pos = 0;

        foreach ($results as $k => $row) {

            if ($doctor_course_result->obtained_mark == $row->obtained_mark) {

                $p = ($k + 1);
                $th = ($p == 1) ? 'st' : (($p == 2) ? 'nd' : (($p == 3) ? 'rd' : 'th'));
                $pos = $p . $th;
                break;

            }

        }

        return $pos;
    }


    function batch_position($exam_id,$batch_id,$doctor_course_result_id)
    {
        $results = Result::where(['exam_id' => $exam_id,'batch_id'=>$batch_id])->orderBy('obtained_mark', 'desc')->get();
        $doctor_course_result = Result::where(['id' => $doctor_course_result_id])->first();



        $pos = 0;

        foreach ($results as $k => $row) {

            if ($doctor_course_result->obtained_mark == $row->obtained_mark) {

                $p = ($k + 1);
                $th = ($p == 1) ? 'st' : (($p == 2) ? 'nd' : (($p == 3) ? 'rd' : 'th'));
                $pos = $p . $th;
                break;

            }

        }

        return $pos;
    }

    function candidate_position($batch_id,$exam_id,$subject_id,$candidate_type,$obtained_mark_single)
    {
        $batchresult = Result::where(['batch_id' => $batch_id, 'exam_id' => $exam_id,'candidate_type'=>$candidate_type])->orderBy('obtained_mark', 'desc')->get();

        $obtained_mark = 0;
        $possition = 0;
        $i = 0;

        foreach ($batchresult as $k => $row) {
            if ($obtained_mark != $row->obtained_mark) {
                $p = ($i + 1);
                $th = ($p == 1) ? 'st' : (($p == 2) ? 'nd' : (($p == 3) ? 'rd' : 'th'));
                $pos = $p . $th;
                $i++;
            } else {
                $pos = $possition;
            }

            $obtained_mark = $row->obtained_mark;
            $possition = $row->possition;

            if($row->obtained_mark == $obtained_mark_single){
                return $pos;
            }
        }
    }

    public function view_doctor_result($doctor_course_id,$id)
    {
        $exam = Exam::find($id);
        $exam->highest_mark  = Result::where('exam_id' , $id)->orderBy('obtained_mark','desc')->value('obtained_mark');
        $doctor_courses = Result::where('exam_id' , $id)->orderBy('obtained_mark','desc')->get();

        $obtained_mark = 0;
        $possition = 0;
        $i = 0;

        foreach ($doctor_courses as $k=>$row){
            if($obtained_mark!=$row->obtained_mark){
                $p = ($i+1);
                $th = ($p==1)?'st':(($p==2)?'nd':(($p==3)?'rd':'th'));
                $row->possition = $p.$th;
                $i++;
            }else{
                $row->possition = $possition;
            }

            $obtained_mark = $row->obtained_mark;
            $possition = $row->possition;

            $row->subject_possition = $this->subject_possition($row->subject_id,$id,$row->obtained_mark);
            $row->batch_possition = $this->batch_possition($row->batch_id,$id,$row->obtained_mark);
            $row->faculty = BcpsFaculty::where(['id'=>$row->faculty_id])->value('name');
        }

        $result = array();

        $results = $doctor_courses;
        foreach ($results as $result)
        {
            if($result->doctor_course_id == $doctor_course_id)
            {
                $result['highest_mark']  = $exam->highest_mark ;
                $result['overall_position'] = $result->possition;
                $result['subject_position'] = $result->subject_possition;
                $result['batch_possition'] = $result->batch_possition;
            }

        }

        return $result;

    }

    public function view_result($id)
    {
        $exam = Exam::find($id);
        $exam->highest_mark  = Result::where('exam_id' , $id)->orderBy('obtained_mark','desc')->value('obtained_mark');
        $doctor_courses = Result::where('exam_id' , $id)->orderBy('obtained_mark','desc')->get();

        $obtained_mark = 0;
        $possition = 0;
        $i = 0;

        foreach ($doctor_courses as $k=>$row){
            if($obtained_mark!=$row->obtained_mark){
                $p = ($i+1);
                $th = ($p==1)?'st':(($p==2)?'nd':(($p==3)?'rd':'th'));
                $row->possition = $p.$th;
                $i++;
            }else{
                $row->possition = $possition;
            }

            $obtained_mark = $row->obtained_mark;
            $possition = $row->possition;

            $row->subject_possition = $this->subject_possition($row->subject_id,$id,$row->obtained_mark);
            $row->batch_possition = $this->batch_possition($row->batch_id,$id,$row->obtained_mark);
            $row->faculty = BcpsFaculty::where(['id'=>$row->faculty_id])->value('name');
        }

        // exit;

        $data['doctor_courses'] = $doctor_courses;

        $data['exam'] = $exam;
        $data['title'] = 'Results';

        $data['paper_faculty'] = QuestionTypes::where('id' , $exam->question_type_id)->value('paper_faculty');

        $data['examination_code']  = Result::where('exam_id' , $id)->value('examination_code');
        $data['candidate_code']  = Result::where('exam_id' , $id)->value('candidate_code');

        return view('admin.exam.view_result', $data);

    }

    function subject_possition($subject_id,$exam_id,$obtained_mark_single)
    {
        $subjectresult = Result::where(['subject_id' => $subject_id, 'exam_id' => $exam_id])->orderBy('obtained_mark', 'desc')->get();

        $obtained_mark = 0;
        $possition = 0;
        $i = 0;

        foreach ($subjectresult as $k => $row) {
            if ($obtained_mark != $row->obtained_mark) {
                $p = ($i + 1);
                $th = ($p == 1) ? 'st' : (($p == 2) ? 'nd' : (($p == 3) ? 'rd' : 'th'));
                $pos = $p . $th;
                $i++;
            } else {
                $pos = $possition;
            }

            $obtained_mark = $row->obtained_mark;
            $possition = $row->possition;

            if($row->obtained_mark == $obtained_mark_single){
                return $pos;
            }



            /*foreach ($subjectresult as $k=>$single){
                if($single->obtained_mark == $obtained_mark){
                    $sp = ($k+1);
                    $th = ($sp==1)?'st':(($sp==2)?'nd':(($sp==3)?'rd':'th'));
                    return $sp.$th;
                }
            }*/
        }
    }


    function batch_possition($batch_id,$exam_id,$obtained_mark_single)
    {
        $batchresult = Result::where(['batch_id' => $batch_id, 'exam_id' => $exam_id])->orderBy('obtained_mark', 'desc')->get();

        $obtained_mark = 0;
        $possition = 0;
        $i = 0;

        foreach ($batchresult as $k => $row) {
            if ($obtained_mark != $row->obtained_mark) {
                $p = ($i + 1);
                $th = ($p == 1) ? 'st' : (($p == 2) ? 'nd' : (($p == 3) ? 'rd' : 'th'));
                $pos = $p . $th;
                $i++;
            } else {
                $pos = $possition;
            }

            $obtained_mark = $row->obtained_mark;
            $possition = $row->possition;

            if($row->obtained_mark == $obtained_mark_single){
                return $pos;
            }
        }
    }



}
