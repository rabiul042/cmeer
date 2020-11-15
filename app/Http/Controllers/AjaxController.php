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



}
