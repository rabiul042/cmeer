<?php

namespace App\Http\Controllers;


use App\Institutes;
use App\Batches;
use App\Sessions;
use App\Subjects;
use App\Chapters;
use App\DoctorsCourses;
use App\Courses;
use App\Faculty;
use App\LectureSheet;
use App\OnlineLectureLink;
use App\LectureVideoBatch;
use App\Divisions;
use App\Districts;
use App\Upazilas;
use App\Exam_question;
use App\Exam;
use App\DoctorAnswers;
use App\DoctorExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;





class AjaxController extends Controller
{
    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //$this->middleware('auth:doctor');
    }



    public function institute_courses(Request $request)
    {
        $institute_id = $request->institute_id;
        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_id'=> $institute_id]);
        $url  = ($institute_id==4)?'course-sessions-subjects':(($institute_id==6)?'course-sessions-faculties':'');
        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('ajax.institute_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function course_changed(Request $request)
    {
        //$course_id = $request->course_id;
        $course = Courses::where(['id'=>$request->course_id])->first();
        if(isset($course->institute->type) && $course->institute->type == '0')
        {
            $sessions = Sessions::join('course_session','course_session.session_id','=','sessions.id')->where('course_id',$course->id)->pluck('name',  'sessions.id');
            $subjects = Subjects::where('course_id',$course->id)->pluck('name', 'id');
            return view('ajax.course_sessions_subjects',['subjects'=>$subjects,'sessions'=>$sessions]);

        }
        else
        {
            $faculties = Faculty::get()->where('course_id',$course->id)->pluck('name', 'id');
            $sessions = Sessions::join('course_session','course_session.session_id','=','sessions.id')->where('course_id',$course->id)->pluck('name',  'sessions.id');
            return view('ajax.course_sessions_faculties',['faculties'=>$faculties,'sessions'=>$sessions]);

        }

    }

    public function faculty_subjects_in_admission(Request $request)
    {
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::where('faculty_id',$faculty_id)
            ->pluck('name', 'id');
        return view('ajax.faculty_subjects_in_admission',['subjects'=>$subjects]);
    }


    /*   for bsmmu  */
    public function course_sessions_faculties(Request $request)
    {
        $course_id = $request->course_id;
        $faculties = Faculty::get()->where('course_id',$course_id)->pluck('name', 'id');
        $sessions = Sessions::join('course_session','course_session.session_id','=','sessions.id')->where('course_id',$course_id)->pluck('name',  'sessions.id');
        return view('ajax.course_sessions_faculties',['faculties'=>$faculties,'sessions'=>$sessions]);
    }

    /*   for bcps  */
    public function course_sessions_subjects(Request $request)
    {
        $course_id = $request->course_id;
        $subjects = Subjects::get()->where('course_id',$course_id)->pluck('name', 'id');
        $sessions = Sessions::join('course_session','course_session.session_id','=','sessions.id')->where('course_id',$course_id)->pluck('name',  'sessions.id');
        return view('ajax.course_sessions_subjects',['subjects'=>$subjects,'sessions'=>$sessions]);
    }

    /*   for bsmmu  */
    public function faculty_subjects(Request $request)
    {
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::where('faculty_id',$faculty_id)
            ->pluck('name', 'id');
        return view('ajax.faculty_subjects',['subjects'=>$subjects]);
    }

    public function courses_branches_subjects_batches(Request $request)
    {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $subject_id = $request->subject_id;
        $branch_id = $request->branch_id;

        if($institute_id == 4){
            $batches = Batches::where([ 'course_id'=>$course_id,'branch_id'=>$branch_id,'subject_id'=>$subject_id ])->pluck('name', 'id');
        }
        else {
            $batches = Batches::where([ 'course_id'=>$course_id,'branch_id'=>$branch_id ])->pluck('name', 'id');
        }

        return  json_encode(array('batches'=>view('ajax.batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

    }

    public function courses_branches_batches(Request $request)
    {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $branch_id = $request->branch_id;

        $batches = Batches::where(['institute_id'=>$institute_id,'course_id'=>$course_id,'branch_id'=>$branch_id ])->pluck('name', 'id');

        return  json_encode(array('batches'=>view('ajax.batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

    }

    public function courses_faculties_batches(Request $request)
    {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $faculties = Faculty::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');


        //return view('admin.ajax.courses_faculties_batches',['faculties'=>$faculties,'batches'=>$batches]);
        return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties,'batches'=>$batches])->render(),'batches'=>view('admin.ajax.courses_batches',['faculties'=>$faculties,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);


    }

    public function courses_subjects_batches(Request $request)
    {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $subjects = Subjects::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');


        return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects,'batches'=>$batches])->render(),'batches'=>view('admin.ajax.courses_batches',['subjects'=>$subjects,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

    }

    public function branches_courses_faculties_batches(Request $request)
    {
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $faculties = Faculty::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->where('branch_id',$branch_id)
            ->pluck('name', 'id');

        //return view('admin.ajax.courses_faculties_batches',['faculties'=>$faculties,'batches'=>$batches]);
        return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties,'batches'=>$batches])->render(),'batches'=>view('admin.ajax.courses_batches',['faculties'=>$faculties,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);


    }

    public function branches_courses_subjects_batches(Request $request)
    {
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $subjects = Subjects::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->where('branch_id',$branch_id)
            ->pluck('name', 'id');


        return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects,'batches'=>$batches])->render(),'batches'=>view('admin.ajax.courses_batches',['subjects'=>$subjects,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

    }



    public function reg_no(Request $request)
    {

        $year = substr($request->year, -2);
        $session = $request->session_id;
        $session = Sessions::where('id',$request->session_id)->pluck('session_code');
        $course_code = Courses::where('id',$request->course_id)->pluck('course_code');
        $batch_code = Batches::where('id',$request->batch_id)->pluck('batch_code');
        $start_index = Batches::where('id',$request->batch_id)->value('start_index');
        $end_index = Batches::where('id',$request->batch_id)->value('end_index');
        $range = 'Batch Range : ( '.$start_index.' - '.$end_index.' ) ';
        $message = '';
        $t_id = '';

        $reg_no_first_part = $year.$session[0].substr($course_code[0], 0, 1).substr($batch_code[0], 0, 1);
        $doctor_course = DoctorsCourses::where(['year'=>$request->year,'session_id'=>$request->session_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->orderBy('reg_no_last_part','desc')->first();

        $reg_no_last_part='';
        if(isset($doctor_course->reg_no_last_part))
        {
            $reg_no_last_part = $doctor_course->reg_no_last_part;
            $reg_no_last_part++;
            $reg_no_last_part = str_pad($reg_no_last_part,3,"0",STR_PAD_LEFT);
        }
        else
        {
            $reg_no_last_part = $start_index;
            $reg_no_last_part = str_pad($reg_no_last_part,3,"0",STR_PAD_LEFT);
        }

        if ($reg_no_last_part > $end_index){

            $array_full_batch = range($start_index,$end_index);
            $array_partial_batch = array();

            $all_reg_no_last_parts = DoctorsCourses::where(['year'=>$request->year,'session_id'=>$request->session_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->orderBy('reg_no_last_part','asc')->pluck('reg_no_last_part')->toArray();
            foreach($all_reg_no_last_parts as $a)
            {
                $array_partial_batch[] = (int)$a;
            }
            $reg_no_last_parts = array();
            $reg_no_last_parts = array_diff($array_full_batch,$array_partial_batch);

            if(count($reg_no_last_parts)>0)
            {
                $reg_no_last_part = array_values($reg_no_last_parts)[0];
                $reg_no_last_part = str_pad($reg_no_last_part,3,"0",STR_PAD_LEFT);
            }
            else if(DoctorsCourses::where(['year'=>$request->year,'session_id'=>$request->session_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id,'is_trash'=>'1'])->orderBy('reg_no_last_part','asc')->first())
            {
                $doctor_course = DoctorsCourses::where(['year'=>$request->year,'session_id'=>$request->session_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id,'is_trash'=>'1'])->orderBy('reg_no_last_part','asc')->first();
                $reg_no_last_part = $doctor_course->reg_no_last_part;
                $t_id = $doctor_course->id;
            }
            else
            {
                $message = '<span style="color:red;">Dear Dr. , The batch you tried is filled up... please try another batch !!!</span>';
            }

        }

        $batch = Batches::where(['course_id'=>$request->course_id,'id'=>$request->batch_id])->first();

        return  json_encode(array('reg_no_first_part'=>$reg_no_first_part,'reg_no_last_part'=>$reg_no_last_part,'t_id'=>$t_id,'range'=>$range,'message'=>$message,'batch_details'=>view('ajax.batch_details',['batch'=>$batch])->render()), JSON_FORCE_OBJECT);

    }

    public function batch_details(Request $request)
    {

        $course_id = $request->course_id;
        $batch_id = $request->batch_id;

        $batch = Batches::where(['course_id'=>$course_id,'id'=>$batch_id])->first();
        //echo '<pre>';print_r($lecture_sheets);exit;
        return  json_encode(array('batch_details'=>view('ajax.batch_details',['batch'=>$batch])->render(),), JSON_FORCE_OBJECT);

    }

    public function ajax_lecture_sheets(Request $request)
    {
        $year = $request->year;
        $session_id = $request->session_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $topic_id = $request->topic_id;

        $lecture_sheets = LectureSheet::where(['year'=>$year,'session_id'=>$session_id,'institute_id'=>$institute_id,'course_id'=>$course_id,'topic_id'=>$topic_id])->get();
        //echo '<pre>';print_r($lecture_sheets);exit;
        return  json_encode(array('lecture_sheets'=>view('lecture_sheet.ajax_lecture_sheets',['lecture_sheets'=>$lecture_sheets])->render(),), JSON_FORCE_OBJECT);

    }

    public function batch_lecture(Request $request)
    {
        $batch_id = $request->batch_id;
        $lecture_id = OnlineLectureLink::select('*')->where('batch_id',$batch_id)->get();
        return view('admin.ajax.batch_lecture',['lectures'=>$lecture_id]);

    }

    public function course_batch(Request $request)
    {
        $course_id = $request->course_id;
        $batch = Batches::select('*')->where('course_id',$course_id)->get()->pluck('name', 'id');
        return view('ajax.course_batch',['batch'=>$batch]);

    }

    public function batch_lecture_video(Request $request)
    {
        $batch_id = $request->batch_id;
        $video = LectureVideoBatch::select('*')->where('batch_id',$batch_id)->first();
        return view('ajax.batch_lecture_video',['video'=>$video, 'doctor_course_id'=>'']);
    }

    public function permanent_division_district(Request $request)
    {
        $division_id = $request->permanent_division_id;
        $districts = Districts::get()->where('division_id',$division_id)->pluck('name', 'id');
        return view('ajax.permanent_division_district',['districts'=>$districts]);
    }

    public function permanent_district_upazila(Request $request)
    {
        $district_id = $request->permanent_district_id;
        $upazilas = Upazilas::get()->where('district_id',$district_id)->pluck('name', 'id');
        return view('ajax.permanent_district_upazila',['upazilas'=>$upazilas]);
    }

    public function present_division_district(Request $request)
    {
        $division_id = $request->present_division_id;
        $districts = Districts::get()->where('division_id',$division_id)->pluck('name', 'id');
        return view('ajax.present_division_district',['districts'=>$districts]);
    }

    public function present_district_upazila(Request $request)
    {
        $district_id = $request->present_district_id;
        $upazilas = Upazilas::get()->where('district_id',$district_id)->pluck('name', 'id');
        return view('ajax.present_district_upazila',['upazilas'=>$upazilas]);
    }

    public function submit_answer(Request $request)
    {
        $data['exam_finish'] = "Next";
        // dd(10);
        $doctor_course_id = $request->doctor_course_id;
        $exam_question_id = $request->exam_question_id;
        $exam_id = $request->exam_id;

        $exam_question = Exam_question::find($exam_question_id);
        $exam = Exam::find($exam_id);

        if($exam->exam_questions->search($exam_question) < $exam->exam_questions->count() )
        {
            if(empty(DoctorAnswers::where(['exam_id'=>$exam_id,'exam_question_id'=>$exam_question->id,'doctor_course_id'=>$doctor_course_id])->first()))
            {

                if($exam_question->question_type == 1)
                {

                    $ans_a = isset($request->ans_a) ? $request->ans_a : '.';
                    $ans_b = isset($request->ans_b) ? $request->ans_b : '.';
                    $ans_c = isset($request->ans_c) ? $request->ans_c : '.';
                    $ans_d = isset($request->ans_d) ? $request->ans_d : '.';
                    $ans_e = isset($request->ans_e) ? $request->ans_e : '.';

                    $answer = $ans_a.$ans_b.$ans_c.$ans_d.$ans_e;

                    DoctorAnswers::insert(['exam_id'=>$exam_id,'exam_question_id'=>$exam_question->id,'doctor_course_id'=>$doctor_course_id,'answer'=>$answer]);

                }
                else
                {
                    $ans_sba = isset($request->ans_sba) ? $request->ans_sba : '.';
                    DoctorAnswers::insert(['exam_id'=>$exam_id,'exam_question_id'=>$exam_question->id,'doctor_course_id'=>$doctor_course_id,'answer'=>$ans_sba]);
                }

            }


        }

        $doctor_answers = DoctorAnswers::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->get();

        $data['doctor_course'] = $doctor_course = DoctorsCourses::where('id',$doctor_course_id)->first();
        $data['exam'] = $exam;
        if($doctor_answers->count() == $exam->exam_questions->count()-1)
        {
            $exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->pluck('exam_question_id')->toArray();
            $exam_questions = Exam_question::whereIn('id',$exam_question_ids)->get();
            $data['exam_question'] = $exam->exam_questions->diff($exam_questions)[0];
            $data['exam_finish'] = "Finish";
            $data['serial_no'] = $exam->exam_questions->search($exam->exam_questions->diff($exam_questions)[0])+1;
            $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");
            return  json_encode(array('question'=>view('ajax.exam',$data)->render(),'data_from'=>'last_question'), JSON_FORCE_OBJECT);
        }
        else if($doctor_answers->count() == $exam->exam_questions->count())
        {
            $data['exam_question'] = $exam->exam_questions[$exam->exam_questions->search($exam_question)];
            $data['exam_finish'] = "Finished";
            $data['serial_no'] = $exam->exam_questions->search($exam_question)+1;
            $this->update_exam_status($doctor_course_id,$exam_id,$status="Completed");
            return  json_encode(array('question'=>view('ajax.exam',$data)->render(),'doctor_course_id'=>$doctor_course->id,'exam_id'=>$exam->id,'redirect'=>"/course-exam-result-submit/".$doctor_course_id."/".$exam->id), JSON_FORCE_OBJECT);

        }
        else
        {
            if($exam->exam_questions->search($exam_question) < $exam->exam_questions->count() - 1 )
            {
                $exam_questions = Exam_question::where(['exam_id'=>$exam->id])->where('id','>',$exam_question->id)->get();
                $doctor_answered_exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->where('exam_question_id','>',$exam_question->id)->pluck('exam_question_id')->toArray();
                $doctor_given_exam_questions = Exam_question::where(['exam_id'=>$exam->id])->whereIn('id',$doctor_answered_exam_question_ids)->get();
                $rest_unanswered_questions = $exam_questions->diff($doctor_given_exam_questions);

                if(isset($rest_unanswered_questions[0])){
                    $data['exam_question'] = $rest_unanswered_questions[0];
                }
                else
                {
                    $exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->pluck('exam_question_id')->toArray();
                    $exam_questions = Exam_question::whereIn('id',$exam_question_ids)->get();
                    $rest_unanswered_questions = $exam->exam_questions->diff($exam_questions);

                    $data['exam_question'] = $rest_unanswered_questions[0];
                }

            }
            else if($exam->exam_questions->search($exam_question) == $exam->exam_questions->count() - 1 ){

                $exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->pluck('exam_question_id')->toArray();
                $exam_questions = Exam_question::whereIn('id',$exam_question_ids)->get();
                $rest_unanswered_questions = $exam->exam_questions->diff($exam_questions);

                $data['exam_question'] = $rest_unanswered_questions[0];

            }

            $data['exam_finish'] = "Next";
            $data['serial_no'] = $exam->exam_questions->search($rest_unanswered_questions[0])+1;
            $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");
            return  json_encode(array('question'=>view('ajax.exam',$data)->render(),'current'=>$exam_question,'next'=>$rest_unanswered_questions[0],'rest'=>$rest_unanswered_questions), JSON_FORCE_OBJECT);
        }


    }

    public function submit_answer_and_terminate_exam(Request $request)
    {
        $doctor_course_id = $request->doctor_course_id;
        $exam_question_id = $request->exam_question_id;
        $exam_id = $request->exam_id;

        $exam_question = Exam_question::find($exam_question_id);
        $exam = Exam::find($exam_id);

        if($exam->exam_questions->search($exam_question) < $exam->exam_questions->count())
        {
            if(empty(DoctorAnswers::where(['exam_id'=>$exam_id,'exam_question_id'=>$exam_question->id,'doctor_course_id'=>$doctor_course_id])->first()))
            {

                if($exam_question->question_type == 1)
                {

                    $ans_a = isset($request->ans_a) ? $request->ans_a : '.';
                    $ans_b = isset($request->ans_b) ? $request->ans_b : '.';
                    $ans_c = isset($request->ans_c) ? $request->ans_c : '.';
                    $ans_d = isset($request->ans_d) ? $request->ans_d : '.';
                    $ans_e = isset($request->ans_e) ? $request->ans_e : '.';

                    $answer = $ans_a.$ans_b.$ans_c.$ans_d.$ans_e;

                    DoctorAnswers::insert(['exam_id'=>$exam_id,'exam_question_id'=>$exam_question->id,'doctor_course_id'=>$doctor_course_id,'answer'=>$answer]);

                }
                else
                {
                    $ans_sba = isset($request->ans_sba) ? $request->ans_sba : '.';
                    DoctorAnswers::insert(['exam_id'=>$exam_id,'exam_question_id'=>$exam_question->id,'doctor_course_id'=>$doctor_course_id,'answer'=>$ans_sba]);
                }

            }

            $this->course_exam_result_submit($doctor_course_id,$exam_id);

            //return  json_encode(array('redirect'=>"/course-exam-result-submit/".$doctor_course_id."/".$exam->id), JSON_FORCE_OBJECT);
            return  json_encode(array('redirect'=>'/course-exam-result/'.$doctor_course_id.'/'.$exam->id), JSON_FORCE_OBJECT);

        }

    }

    public function course_exam_result_submit($doctor_course_id,$exam_id)
    {
        $exam = Exam::where('id',$exam_id)->first();
        $doctor_course = DoctorsCourses::where('id',$doctor_course_id)->first();
        /*if(DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course->id])->count() ==  $exam->exam_questions->count())
        {*/
        $correct_mark = 0;
        $negative_mark = 0;
        $wrong_answer =0;
        $mcq_mark = $exam->question_type->mcq_mark/5;
        $sba_mark = $exam->question_type->sba_mark;
        $mcq_negative_mark = $exam->question_type->mcq_negative_mark;
        $sba_negative_mark = $exam->question_type->sba_negative_mark;
        $obtained_mark = 0;

        $doctor_answers = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course->id])->get();

        foreach ($doctor_answers as $doctor_answer)
        {
            if($doctor_answer->exam_question->question->type == 1)
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
            else if($doctor_answer->exam_question->question->type == 2)
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

        $this->update_exam_status($doctor_course_id,$exam_id,$status="Completed");

        return redirect('course-exam-result/'.$doctor_course->id.'/'.$exam->id);

    }

    public function skip_question(Request $request)
    {
        $doctor_course_id = $request->doctor_course_id;
        $exam_question_id = $request->exam_question_id;
        $exam_id = $request->exam_id;

        $exam_question = Exam_question::find($exam_question_id);
        $exam = Exam::find($exam_id);



        $doctor_answers = DoctorAnswers::where(['exam_id'=>$exam_id,'doctor_course_id'=>$doctor_course_id])->get();

        $data['doctor_course'] = $doctor_course = DoctorsCourses::where('id',$doctor_course_id)->first();
        $data['exam'] = $exam;
        if($doctor_answers->count() == $exam->exam_questions->count()-1)
        {
            $exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->pluck('exam_question_id')->toArray();
            $exam_questions = Exam_question::whereIn('id',$exam_question_ids)->get();
            $data['exam_question'] = $exam->exam_questions->diff($exam_questions)[0];
            $data['exam_finish'] = "Finish";
            $data['serial_no'] = $exam->exam_questions->search($exam->exam_questions->diff($exam_questions)[0])+1;
            $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");
            return  json_encode(array('question'=>view('ajax.exam',$data)->render(),'data_from'=>'last_question'), JSON_FORCE_OBJECT);
        }
        else if($doctor_answers->count() == $exam->exam_questions->count())
        {
            $data['exam_question'] = $exam->exam_questions[$exam->exam_questions->search($exam_question)];
            $data['exam_finish'] = "Finished";
            $data['serial_no'] = $exam->exam_questions->search($exam_question)+1;
            $this->update_exam_status($doctor_course_id,$exam_id,$status="Completed");
            return  json_encode(array('question'=>view('ajax.exam',$data)->render(),'doctor_course_id'=>$doctor_course->id,'exam_id'=>$exam->id,'redirect'=>"/course-exam-result-submit/".$doctor_course_id."/".$exam->id), JSON_FORCE_OBJECT);

        }
        else
        {

            if($exam->exam_questions->search($exam_question) < $exam->exam_questions->count() - 1 )
            {
                $exam_questions = Exam_question::where(['exam_id'=>$exam->id])->where('id','>',$exam_question->id)->get();
                $doctor_answered_exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->where('exam_question_id','>',$exam_question->id)->pluck('exam_question_id')->toArray();
                $doctor_given_exam_questions = Exam_question::where(['exam_id'=>$exam->id])->whereIn('id',$doctor_answered_exam_question_ids)->get();
                $rest_unanswered_questions = $exam_questions->diff($doctor_given_exam_questions);

                if(isset($rest_unanswered_questions[0])){
                    $data['exam_question'] = $rest_unanswered_questions[0];
                }
                else
                {
                    $exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->pluck('exam_question_id')->toArray();
                    $exam_questions = Exam_question::whereIn('id',$exam_question_ids)->get();
                    $rest_unanswered_questions = $exam->exam_questions->diff($exam_questions);

                    $data['exam_question'] = $rest_unanswered_questions[0];
                }

            }
            else if($exam->exam_questions->search($exam_question) == $exam->exam_questions->count() - 1 ){

                $exam_question_ids = DoctorAnswers::where(['exam_id'=>$exam->id,'doctor_course_id'=>$doctor_course_id])->pluck('exam_question_id')->toArray();
                $exam_questions = Exam_question::whereIn('id',$exam_question_ids)->get();
                $rest_unanswered_questions = $exam->exam_questions->diff($exam_questions);

                $data['exam_question'] = $rest_unanswered_questions[0];

            }

            $data['exam_finish'] = "Next";
            $data['serial_no'] = $exam->exam_questions->search($rest_unanswered_questions[0])+1;
            $this->update_exam_status($doctor_course_id,$exam_id,$status="Running");
            return  json_encode(array('question'=>view('ajax.exam',$data)->render(),'current'=>$exam_question,'next'=>$rest_unanswered_questions[0],'rest'=>$rest_unanswered_questions), JSON_FORCE_OBJECT);

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

}
