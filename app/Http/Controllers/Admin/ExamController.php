<?php
namespace App\Http\Controllers\Admin;

use App\BcpsFaculty;
use App\DoctorAnswers;
use App\DoctorsCourses;
use App\Http\Controllers\Controller;
use App\Question_ans;
use Illuminate\Http\Request;
use App\Exam;
use App\Exam_question;
use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Subjects;
use App\Sessions;
use App\Topics;
use App\Exam_topic;
use App\QuestionTypes;
use App\Batches;
use App\Question;
use App\Result;
use App\Exam_type;
use App\Teacher;
use Session;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;


class ExamController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        ini_set('max_execution_time', 3000);
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*  if(!$user->hasRole('Admin')){
              return abort(404);
          }*/
        $Exams = Exam::get();
        $title = 'Exam List';
        return view('admin.exam.list', ['exams' => $Exams, 'title' => $title]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user=Subjects::find(Auth::id());
        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/


        $years = array('' => 'Select Year');
        for ($year = date("Y") + 1; $year >= 2017; $year--) {
            $years[$year] = $year;
        }
        $sessions = Sessions::get()->pluck('name', 'id');
        $papers = array('' => 'Select Paper', '1' => 'Paper-I', '2' => 'Paper-II', '3' => 'Paper-III');
        $question_type = QuestionTypes::get()->pluck('title', 'id');
        $exam_type = Exam_type::get()->pluck('name', 'id');
        $teacher = Teacher::get()->pluck('name', 'id');

        $institute = Institutes::get()->pluck('name', 'id');
        $batches = Batches::get()->pluck('name', 'id');
        $mcqs = Question::where('type', 1)->get()->pluck('question_title', 'id');
        $sbas = Question::where('type', 2)->get()->pluck('question_title', 'id');
        //$topic = Topics::where('status', 1)->get()->pluck('name', 'id');

        $title = 'Exam Create';

        return view('admin.exam.create', (['institute' => $institute, 'batches' => $batches, 'mcqs' => $mcqs, 'sbas' => $sbas, 'years' => $years, 'sessions' => $sessions, 'papers' => $papers, 'exam_type' => $exam_type, 'teacher' => $teacher, 'question_type' => $question_type, 'title' => $title]));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'exam_date' => ['required'],
            'year' => ['required'],
            'session_id' => ['required'],
            'exam_type_id' => ['required'],
            'question_type_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'is_free' => ['required'],
            'sif_only' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\ExamController@create')->withInput();
        }

        if (Exam::where('name', $request->name)->exists()) {
            Session::flash('class', 'alert-danger');
            session()->flash('message', 'This Exam  already exists');
            return redirect()->action('Admin\ExamController@create')->withInput();
        } else {
            $exam = new Exam;
            $exam->name = $request->name;
            $exam->institute_id = $request->institute_id;
            $exam->course_id = $request->course_id;
            $exam->faculty_id = $request->faculty_id;
            $exam->subject_id = $request->subject_id;
            $exam->batch_id = $request->batch_id;
            $exam->is_free = $request->is_free;
            $exam->exam_details = $request->exam_details;
            $exam->status = $request->status;
            $exam->exam_date = $request->exam_date;
            $exam->year = $request->year;
            $exam->session_id = $request->session_id;
            $exam->paper = $request->paper;
            $exam->teacher_id = $request->teacher_id;
            $exam->exam_type_id = $request->exam_type_id;
            $exam->question_type_id = $request->question_type_id;
            $exam->sif_only = $request->sif_only;

            $exam->save();

            if ($request->mcq_question_id) {
                foreach ($request->mcq_question_id as $k => $value) {
                    Exam_question::insert(['question_id' => $value, 'exam_id' => $exam->id, 'question_type' => 1]);
                }
            }

            if ($request->sba_question_id) {
                foreach ($request->sba_question_id as $k => $value) {
                    Exam_question::insert(['question_id' => $value, 'exam_id' => $exam->id, 'question_type' => 2]);
                }
            }

            if ($request->topic_id) {
                foreach ($request->topic_id as $k => $value) {
                    Exam_topic::insert(['topic_id' => $value, 'exam_id' => $exam->id]);
                }
            }
            Session::flash('message', 'Record has been added successfully');
            return redirect()->action('Admin\ExamController@index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Subjects::select('users.*')->find($id);
        return view('admin.subjects.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=Subjects::find(Auth::id());
         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/

        $data['exam'] = Exam::find($id);

        $years = array('' => 'Select Year');
        for ($year = date("Y") + 1; $year >= 2017; $year--) {
            $years[$year] = $year;
        }
        $data['years'] = $years;
        $data['sessions'] = Sessions::get()->pluck('name', 'id');
        $data['papers'] = array('' => 'Select Paper', '1' => 'Paper-I', '2' => 'Paper-II', '3' => 'Paper-III');
        $data['question_types'] = QuestionTypes::get()->pluck('title', 'id');
        $data['question_type'] = QuestionTypes::where('id', $data['exam']->question_type_id)->first();


        $data['mcqs_ids'] = Exam_question::where(['exam_id' => $id, 'question_type' => 1])->pluck('question_id');
        $data['mcqs'] = DB::table('question')->whereIn('id', $data['mcqs_ids'])->pluck(DB::raw('CONCAT(question_title, " (", id,")") AS question_title'), 'id');

        $data['sbas_ids'] = Exam_question::where(['exam_id' => $id, 'question_type' => 2])->pluck('question_id');
        $data['sbas'] = DB::table('question')->whereIn('id', $data['sbas_ids'])->pluck(DB::raw('CONCAT(question_title, " (", id,")") AS question_title'), 'id');


        $data['exam_type'] = Exam_type::get()->pluck('name', 'id');
        $data['teacher'] = Teacher::get()->pluck('name', 'id');

        $data['topic'] = Topics::where(['course_id' => $data['exam']->course_id, 'status' => 1])->pluck('name', 'id');
        $data['topic_ids'] = Exam_topic::where('exam_id', $id)->pluck('topic_id');


        $data['institute'] = Institutes::get()->pluck('name', 'id');
        $data['institute_type'] = Institutes::where('id', $data['exam']->institute_id)->value('type');
        $data['course'] = Courses::where('institute_id', $data['exam']->institute_id)->pluck('name', 'id');
        if ($data['institute_type'] == 1) {
            $data['faculty'] = Faculty::where('course_id', $data['exam']->course_id)->pluck('name', 'id');
            $data['subject'] = Subjects::where('faculty_id', $data['exam']->faculty_id)->pluck('name', 'id');
        } else {
            $data['subject'] = Subjects::where('course_id', $data['exam']->course_id)->pluck('name', 'id');
        }

        $data['batches'] = Batches::get()->pluck('name', 'id');
        $data['title'] = 'Exam Edit';
        return view('admin.exam.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'exam_date' => ['required'],
            'year' => ['required'],
            'session_id' => ['required'],
            'exam_type_id' => ['required'],
            'question_type_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'is_free' => ['required'],
            'sif_only' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\ExamController@edit',[$id])->withInput();
        }


        $exam = Exam::find($id);
        if ($request->name != $exam->name) {
            if (Exam::where('name', $request->name)->exists()) {
                Session::flash('class', 'alert-danger');
                session()->flash('message', 'This Exam already exists');
                return redirect()->back()->withInput();
            }
        }

        $exam->name = $request->name;
        $exam->institute_id = $request->institute_id;
        $exam->course_id = $request->course_id;
        $exam->faculty_id = $request->faculty_id;
        $exam->subject_id = $request->subject_id;
        $exam->batch_id = $request->batch_id;
        $exam->is_free = $request->is_free;
        $exam->exam_details = $request->exam_details;
        $exam->status = $request->status;
        $exam->exam_date = $request->exam_date;
        $exam->year = $request->year;
        $exam->session_id = $request->session_id;
        $exam->paper = $request->paper;
        $exam->teacher_id = $request->teacher_id;
        $exam->exam_type_id = $request->exam_type_id;
        $exam->question_type_id = $request->question_type_id;
        $exam->sif_only = $request->sif_only;

        Exam_topic::where('exam_id', $id)->delete();
        if ($request->topic_id) {
            foreach ($request->topic_id as $k => $value) {
                Exam_topic::insert(['topic_id' => $value, 'exam_id' => $exam->id]);
            }
        }
        Exam_question::where(['exam_id' => $id, 'question_type' => 1])->delete();
        if ($request->mcq_question_id) {
            foreach ($request->mcq_question_id as $k => $value) {
                Exam_question::insert(['question_id' => $value, 'exam_id' => $id, 'question_type' => 1]);
            }
        }
        Exam_question::where(['exam_id' => $id, 'question_type' => 2])->delete();
        if ($request->sba_question_id) {
            foreach ($request->sba_question_id as $k => $value) {
                Exam_question::insert(['question_id' => $value, 'exam_id' => $id, 'question_type' => 2]);
            }
        }

        $exam->push();
        Session::flash('message', 'Record has been updated successfully');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       /* $user = Subjects::find(Auth::id());
        if (!$user->hasRole('Admin')) {
            return abort(404);
        }*/
        Exam::destroy($id); // 1 way
        Result::where('exam_id',$id)->delete();
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\ExamController@index');
    }

    public function print($id)
    {
        $data['exam_id'] = Exam::find($id);
        $data['question_id'] = Exam_question::where('exam_id', $id)->get();
        foreach ($data['question_id'] as $result) {
            $data['questions'][$result->question_title][] = $result;
        }

        $data['exam_id'] = Exam::find($id);
        $data['topic_id'] = Exam_topic::where('exam_id', $id)->get();
        foreach ($data['topic_id'] as $result) {
            $data['topics'][$result->name][] = $result;
        }

        Exam::where('id', $id)
            ->update(['is_print' => 'Yes']);

        $exam_info = Exam::where('id', $id)->first();
        $data['exam_info'] = Exam::where('id', $id)->first();
        /*$topic_info = Exam_topic::where('exam_id', $exam_info->id)->first();
        $data['topic_info'] = Topics::where('id', $topic_info->topic_id)->get();*/
        $question_type_id = Exam::where('question_type_id', $exam_info->question_type_id)->first();
        $data['question_type_info'] = QuestionTypes::where('id', $question_type_id->question_type_id)->first();
        return view('admin.exam.print', $data);
        //echo "hi";
    }


    public function print_ans($id)
    {

        $data['exam_id'] = Exam::find($id);

        $data['question_id'] = Exam_question::where('exam_id', $id)->get();
        foreach ($data['question_id'] as $result) {
            $data['questions'][$result->question_title][] = $result;
        }

        $exam_info = Exam::where('id', $id)->first();
        $data['exam_info'] = Exam::where('id', $id)->first();
        /*$topic_info = Exam_topic::where('exam_id', $exam_info->id)->first();
        $data['topic_name'] = Topics::where('id', $topic_info->topic_id)->first();*/
        $question_type_id = Exam::where('question_type_id', $exam_info->question_type_id)->first();
        $data['question_type_info'] = QuestionTypes::where('id', $question_type_id->question_type_id)->first();
        return view('admin.exam.print_ans', $data);

    }

    public function print_onlyans($id)
    {

        $data['exam_id'] = Exam::find($id);

        $data['question_id'] = Exam_question::where('exam_id', $id)->get();
        foreach ($data['question_id'] as $result) {
            $data['questions'][$result->question_title][] = $result;
        }

        $exam_info = Exam::where('id', $id)->first();
        $data['exam_info'] = Exam::where('id', $id)->first();
        /*$topic_info = Exam_topic::where('exam_id', $exam_info->id)->first();
        $data['topic_name'] = Topics::where('id', $topic_info->topic_id)->first();*/
        $question_type_id = Exam::where('question_type_id', $exam_info->question_type_id)->first();
        $data['question_type_info'] = QuestionTypes::where('id', $question_type_id->question_type_id)->first();
        return view('admin.exam.print_onlyans', $data);

    }


    public function upload_result($id)
    {
       $data['exam_info'] = $exam_id = Exam::find($id);
        $data['title'] = 'Upload Result';
        $institute_type = $exam_id->institute->type;
        if($institute_type==1){
            return view('admin.exam.upload_result_faculty', $data);
        }
        return view('admin.exam.upload_result', $data);

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


    public function result_submit(Request $request)
    {
        $file = $request->file('result');
        $answer = $request->file('answer');

        $result = explode("\r\n", trim(file_get_contents($file->getRealPath())));

        $canswertotal = file_get_contents($answer->getRealPath());

        $exam_id = $request->exam_id;
        $question_type_id = Exam::where('id', $exam_id)->first()->question_type_id;
        $exam_year = Exam::where('id', $exam_id)->first()->year;
        $question_type = QuestionTypes::where('id', $question_type_id)->first();
        $mcq_mark = $question_type->mcq_mark/5;
        $mcq_negative_mark = $question_type->mcq_negative_mark;
        $sba_mark = $question_type->sba_mark;
        $sba_negative_mark = $question_type->sba_negative_mark;
        $exam_question_ids = Exam_question::where('exam_id', $exam_id)->get();
        $result_insert = 0;

        $paper_faculty = $question_type->paper_faculty;


        //Result File save to result/exam_id/file_name
        $file_name = time()."_".$file->getClientOriginalName();
        $file_Path = 'result/'.$request->exam_id.'/';
        $file->move($file_Path,$file_name);

        for ($i = 0; $i < count($result); $i++) {  //echo 'ok';
            $ind_result = $result[$i];
            $registration =  substr($exam_year,2,2).substr($ind_result, 0, 6);

            $doctor_course_id = DoctorsCourses::where('reg_no', $registration)->value('id');
            $batch_id = DoctorsCourses::where('reg_no', $registration)->value('batch_id');
            $course_id = DoctorsCourses::where('reg_no', $registration)->value('course_id');
            $omr_subject_code = substr($ind_result, 8, 1);
            $subject_id = Subjects::where(['course_id'=>$course_id,'subject_omr_code'=> $omr_subject_code])->value('id');
            $set_code = substr($ind_result, 6, 1);

            if($paper_faculty=='Paper'){
                $paper_code = substr($ind_result, 6, 1);
                $faculty_id= '';
            }elseif ($paper_faculty=='Faculty'){
                $omr_faculty_code = substr($ind_result, 7, 1);
                $faculty_id = BcpsFaculty::where('omr_code', $omr_faculty_code)->value('id');
                $paper_code = '';
            }else{
                $faculty_id= '';
                $paper_code = '';
            }

            if($doctor_course_id && !(Result::where(['doctor_course_id'=> $doctor_course_id,'exam_id'=> $exam_id])->exists())){

                $result_insert++;
                if($paper_faculty=='None'){
                    $ind_result = substr($ind_result, 8);
                } else {
                    $ind_result = substr($ind_result, 9);
                }

                $mcqans = substr($ind_result, 0, $question_type->mcq_number * 5);
                $sbaans = substr($ind_result, $question_type->mcq_number * 5, ($question_type->sba_number + $question_type->mcq_number * 5));

                /*doctor result insert batch wise */
                $mark = 0;
                $m = 0;
                $s = 0;
                $wrong_answer = 0;
                $n_mark = 0;

                $total_question = $question_type->mcq_number+$question_type->sba_number;

                $sba_correct_answer = substr($canswertotal,$question_type->mcq_number*5);

                for ($x=0;$x<$total_question;$x++) {


                    if ($question_type->mcq_number > $x) {
                        $y = 0;
                        $asb = substr($mcqans, $m, 5);

                        $correcans = str_split(substr($canswertotal, $m, 5));

                        for ($j=0;$j<5;$j++) {
                            if ($correcans[$j] == substr($asb, $y, 1)) {
                                $mark += $mcq_mark;
                            }else{

                                if(substr($asb, $y, 1)!='.'){
                                    $n_mark += $mcq_negative_mark;
                                    if(substr($asb, $y, 1)!='>'){
                                        $wrong_answer++;
                                    }

                                }
                            }
                            ++$y;
                        }
                        $m +=5;
                    } else {
                        if (substr($sba_correct_answer, $s, 1) == substr($sbaans, $s, 1)) {
                            $mark += $sba_mark;
                        }else{
                            if(substr($sbaans, $s, 1)!='.'){
                                $n_mark += $sba_negative_mark;
                                if(substr($sbaans, $s, 1)!='>'){
                                    $wrong_answer++;
                                }
                            }
                        }
                        $s++;
                    }
                }


                Result::insert([
                    'doctor_course_id' => $doctor_course_id,
                    'exam_id' => $exam_id,
                    'subject_id'=>$subject_id,
                    'correct_mark' => $mark,
                    'negative_mark' => $n_mark,
                    'obtained_mark' => $mark-$n_mark,
                    'obtained_mark_decimal' => ($mark-$n_mark)*100,
                    'wrong_answers'=>$wrong_answer,
                    'batch_id'=>$batch_id,
                    'file_name'=>$file_name,
                    'paper_code'=>$paper_code,
                    'faculty_id'=>$faculty_id
                ]);
            }
        }

        $result_insert = ($result_insert==0)?'No result Added':$result_insert.' results added successfully';
        Session::flash('message', $result_insert);

        return redirect('admin/view-result/' . $exam_id);

    }

    public function result_submit_faculty(Request $request)
    {
        $file_front_part = $request->file('result_front_part');
        $file_back_part = $request->file('result_back_part');
        $file_last_part = $request->file('result_last_part');

        $answer = $request->file('answer');

        $result_front_part = explode("\r\n", file_get_contents($file_front_part->getRealPath()));
        if($file_back_part){
            $result_back_part = explode("\r\n", file_get_contents($file_back_part->getRealPath()));
        }
        if($file_last_part){
            $result_last_part = explode("\r\n", file_get_contents($file_last_part->getRealPath()));
        }

        $canswertotal = file_get_contents($answer->getRealPath());


        //Result File save to result/exam_id/file_name
        $file_name = time()."_".$file_front_part->getClientOriginalName();
        $file_Path = 'result/'.$request->exam_id.'/';
        $file_front_part->move($file_Path,$file_name);

        $exam_id = $request->exam_id;
        $question_type_id = Exam::where('id', $exam_id)->first()->question_type_id;
        $exam_year = Exam::where('id', $exam_id)->first()->year;

        $question_type = QuestionTypes::where('id', $question_type_id)->first();
        $exam_question_ids = Exam_question::where('exam_id', $exam_id)->get();

        $mcq_mark = $question_type->mcq_mark/5;
        $mcq_negative_mark = $question_type->mcq_negative_mark;
        $sba_mark = $question_type->sba_mark;
        $sba_negative_mark = $question_type->sba_negative_mark;

        $result_insert = 0;


        for ($i = 0; $i < count($result_front_part); $i++) {  //print_r($result_back_part);exit;
            $ind_result = $result_front_part[$i];
            $registration_without_year = substr($ind_result, 0, 6);
            $registration =  substr($exam_year,2,2).$registration_without_year;

            $doctor_course_id = DoctorsCourses::where('reg_no', $registration)->value('id');
            $course_id = DoctorsCourses::where('reg_no', $registration)->value('course_id');

            $omr_faculty_code = substr($ind_result, 8, 1);
            $faculty_id = Faculty::where('faculty_omr_code', $omr_faculty_code)->value('id');

            $batch_id = DoctorsCourses::where('reg_no', $registration)->value('batch_id');

            $examination_code = substr($ind_result, 6, 1);
            $set_code = substr($ind_result, 7, 1);

            $candidate_code = substr($ind_result, 9, 1);

            $s_code_10 = substr($ind_result, 10, 1);
            $s_code_11 = substr($ind_result, 11, 1);

            if ($s_code_10=='.' && $s_code_11!='.') {
                $omr_subject_code = substr($ind_result, 11, 1);
                $subject_id = Subjects::where(['course_id'=>$course_id,'subject_omr_code'=> $omr_subject_code])->value('id');
            } elseif ($s_code_10!='.' && $s_code_11=='.') {
                $omr_subject_code = substr($ind_result, 10, 1);
                $subject_id = Subjects::where(['course_id'=>$course_id,'subject_omr_code'=> $omr_subject_code])->value('id');
            } else {
                $subject_id = '';
            }


            if($registration_without_year && $doctor_course_id && !(Result::where(['doctor_course_id'=> $doctor_course_id,'exam_id'=> $exam_id])->exists())){

                $result_insert++;

                $ind_result = substr($ind_result, 12);

                $input = preg_quote($registration_without_year, '~'); // don't forget to quote input string!

                if(isset($result_back_part)){
                    $ans_back_part = preg_grep('~' . $input . '~', $result_back_part);
                    $ans_back_part = implode("|",$ans_back_part);
                    $ans_back_part = substr($ans_back_part,6);
                    $ind_result = trim($ind_result).trim($ans_back_part);
                }

                if(isset($result_last_part)){
                    $ans_last_part = preg_grep('~' . $input . '~', $result_last_part);
                    $ans_last_part = implode("|",$ans_last_part);
                    $ans_last_part = substr($ans_last_part,6);
                    $ind_result = trim($ind_result).trim($ans_last_part);
                }

                $mcqans = substr($ind_result, 0, $question_type->mcq_number * 5);
                $sbaans = substr($ind_result, $question_type->mcq_number * 5, ($question_type->sba_number + $question_type->mcq_number * 5));

                /*doctor result insert batch wise */
                $mark = 0;
                $m = 0;
                $s = 0;
                $wrong_answer = 0;
                $n_mark = 0;

                $total_question = $question_type->mcq_number+$question_type->sba_number;

                $sba_correct_answer = substr($canswertotal,$question_type->mcq_number*5);

                for ($x=0;$x<$total_question;$x++) {


                    if ($question_type->mcq_number > $x) {
                        $y = 0;
                        $asb = substr($mcqans, $m, 5);

                        $correcans = str_split(substr($canswertotal, $m, 5));

                        for ($j=0;$j<5;$j++) {
                            if ($correcans[$j] == substr($asb, $y, 1)) {
                                $mark += $mcq_mark;
                            }else{

                                if(substr($asb, $y, 1)!='.'){
                                    $n_mark += $mcq_negative_mark;
                                    if(substr($asb, $y, 1)!='>'){
                                        $wrong_answer++;
                                    }

                                }
                            }
                            ++$y;
                        }
                        $m +=5;
                    } else {
                        if (substr($sba_correct_answer, $s, 1) == substr($sbaans, $s, 1)) {
                            $mark += $sba_mark;
                        }else{
                            if(substr($sbaans, $s, 1)!='.'){
                                $n_mark += $sba_negative_mark;
                                if(substr($sbaans, $s, 1)!='>'){
                                    $wrong_answer++;
                                }
                            }
                        }
                        $s++;
                    }
                }


                Result::insert([
                    'doctor_course_id' => $doctor_course_id,
                    'exam_id' => $exam_id,
                    'subject_id'=>$subject_id,
                    'correct_mark' => $mark,
                    'negative_mark' => $n_mark,
                    'obtained_mark' => $mark-$n_mark,
                    'obtained_mark_decimal' => ($mark-$n_mark)*100,
                    'wrong_answers'=>$wrong_answer,
                    'batch_id'=>$batch_id,
                    'file_name'=>$file_name,
                    'faculty_id'=>$faculty_id,
                    'examination_code'=>$examination_code,
                    'candidate_code'=>$candidate_code
                ]);
            }

        }

        $result_insert = ($result_insert==0)?'No result Added':$result_insert.' results added successfully';
        Session::flash('message', $result_insert);
        

        return redirect('admin/view-result/' . $exam_id);
    }




}
