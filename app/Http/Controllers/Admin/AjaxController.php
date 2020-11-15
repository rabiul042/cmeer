<?php

namespace App\Http\Controllers\Admin;


use App\BatchesSchedules;
use App\BatchesSchedulesSlots;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use App\Institutes;
use App\Batches;
use App\Districts;
use App\Question;
use App\Sessions;
use App\Topics;
use App\Teacher;
use App\Upazilas;
use App\Subjects;
use App\Chapters;
use App\Doctors;
use App\WeekDays;
use App\LectureVideo;
use App\OnlineExam;

use App\Courses;
use App\Faculty;
use App\QuestionTypes;
use App\Notices;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Session;
use Auth;





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
        //$this->middleware('auth');

    }

    public function notice_type(Request $request)
    {
        $type = $request->type;
        if($type=='I') {
            $data['doctors'] = Doctors::select(DB::raw("CONCAT(name,' - ',bmdc_no) AS full_name"),'id')->orderBy('id', 'DESC')->pluck('full_name', 'id');
            $data['type']=$type;
            return view('admin.ajax.notice_type_individual', $data);
        } 
        if ($type=='B') {
            $data['years'] = array(''=>'Select year');
            for($year = date("Y")+1;$year>=2019;$year--){$data['years'][$year] = $year;}
            $data['sessions'] = Sessions::get()->pluck('name', 'id');
            $data['institute'] = Institutes::get()->pluck('name', 'id');
            $data['type']=$type;
            return view('admin.ajax.notice_type_batch', $data);
        }
    }

    public function notice_search_doctors(Request $request)
    {
        $text =  $_GET['term'];
        $text = $text['term'];

        $data = Doctors::select(DB::raw("CONCAT(name,' - ',bmdc_no) AS name_bmdc"),'id')
            ->where('name', 'like', '%'.$text.'%')
            ->orWhere('bmdc_no', 'like', '%'.$text.'%')
            ->get();
        //$data = DB::table('institution')->where('institution_type_id',$content_section_id)->where('name', 'like', $text.'%')->get();
        echo json_encode( $data);
    }

    public function notice_institute_course(Request $request)
    {
        $institute_id = $request->institute_id;
        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.notice_institute_course',['courses'=>$courses]);
    }

    public function notice_course_batch(Request $request)
    {
        $course_id = $request->course_id;
        $batches = Batches::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.notice_course_batch',['batches'=>$batches]);
    }

    public function check_bmdc_no(Request $request)
    {
        $bmdc_no = $request->bmdc_no;
        $bmdc_status = Doctors::where('bmdc_no',$bmdc_no)->first();
        if ($bmdc_status){
            $bmdc_status = 1;
            return view('admin.ajax.check_bmdc_no',['bmdc_status'=>$bmdc_status]);
        } else {
            $bmdc_status = 0;
            return view('admin.ajax.check_bmdc_no',['bmdc_status'=>$bmdc_status]);
        }
    }

    public function check_email(Request $request)
    {
        $email = $request->email;
        $email_status = Doctors::where('email',$email)->first();
        if ($email_status){
            $email_status = 1;
            return view('admin.ajax.check_email',['email_status'=>$email_status]);
        } else {
            $email_status = 0;
            return view('admin.ajax.check_email',['email_status'=>$email_status]);
        }
    }

    public function sif_only(Request $request)
    {
        if($request->sif_only==0){
            $data['question_type'] = QuestionTypes::get()->pluck('title', 'id');
            return view('admin.ajax.question_type', $data);
        }

    }



    public function question_type(Request $request)
    {
        $type_id = $request->question_type;
        $type_id = QuestionTypes::get()->where('id',$type_id)->pluck('subject_name', 'id');
        return view('admin.ajax.book_subject',['subjects'=>$subjects]);
    }

    public function institute_course(Request $request)
    {
        $institute_id = $request->institute_id;
        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'course-faculty':'course-subject';
        $course = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_course',['course'=>$course,'url'=>$url]);
    }
    public function course_subject(Request $request)
    {
        $course_id = $request->course_id;
        $subject = Subjects::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.faculty_subject',['subject'=>$subject]);
    }

    public function course_subjects(Request $request)
    {
        $course_id = $request->course_id;
        $subjects = Subjects::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.subjects',['subjects'=>$subjects]);
    }

    public function course_topics(Request $request)
    {
        $course_id = $request->course_id;
        $topics = Topics::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.course_topics',['topics'=>$topics]);
    }

    public function course_topic(Request $request)
    {
        $course_id = $request->course_id;
        $topics = Topics::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.topics',['topics'=>$topics]);
    }

    public function course_faculty(Request $request)
    {
       if(Session('institute_type')) {
           $course_id = $request->course_id;
           $faculty = Faculty::get()->where('course_id', $course_id)->pluck('name', 'id');
           return view('admin.ajax.course_faculty', ['faculty' => $faculty]);
       }
    }


    public function faculty_subject(Request $request)
    {
        $faculty_id = $request->faculty_id;
        $subject = Subjects::get()->where('faculty_id',$faculty_id)->pluck('name', 'id');
        return view('admin.ajax.faculty_subject',['subject'=>$subject]);
    }

    public function institutes_courses(Request $request)
    {
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'courses-faculties':'courses-subjects';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institutes_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function institute_courses(Request $request)
    {
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'courses-faculties-batches':'courses-subjects-batches';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function institute_courses_in_online_exams(Request $request)
    {
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'courses-faculties-batches':'courses-subjects-batches';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_courses_in_online_exams',['courses'=>$courses,'url'=>$url]);
    }

    public function branch_institute_courses(Request $request)
    {
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'branches-courses-faculties-batches':'branches-courses-subjects-batches';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function institute_courses_for_topics_batches(Request $request)
    {
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'courses-faculties-topics-batches':'courses-subjects-topics-batches';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function institute_courses_for_lectures_topics_batches(Request $request)
    { 
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'courses-faculties-topics-batches-lectures':'courses-subjects-topics-batches-lectures';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function institute_courses_for_lectures_videos(Request $request)
    { 
        $institute_id = $request->institute_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $url  = ($institute_type)?'courses-faculties-batches-lectures-videos':'courses-subjects-batches-lectures-videos';

        $courses = Courses::get()->where('institute_id',$institute_id)->pluck('name', 'id');
        return view('admin.ajax.institute_courses',['courses'=>$courses,'url'=>$url]);
    }

    public function courses_faculties(Request $request)
    {
        $course_id = $request->course_id;
        $faculties = Faculty::get()->where('course_id',$course_id)->pluck('name', 'id');
        $batches = Batches::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.courses_faculties',['faculties'=>$faculties,'batches'=>$batches]);
    }


     public function courses_subjects(Request $request)
    {
        $course_id = $request->course_id;
        $subjects = Subjects::get()->where('course_id',$course_id)->pluck('name', 'id');
        $batches = Batches::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.faculties_subjects',['subjects'=>$subjects,'batches'=>$batches]);
     }

    public function courses_batches(Request $request)
    {
        $course_id = $request->course_id;
        $batches = Batches::get()->where('course_id',$course_id)->pluck('name', 'id');
        return view('admin.ajax.courses_batches',['batches'=>$batches]);

    }

    public function faculties_subjects(Request $request)
    {
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::get()->where('faculty_id',$faculty_id)->pluck('name', 'id');
        return view('admin.ajax.faculties_subjects',['subjects'=>$subjects]);
    }

    public function faculty_subjects(Request $request)
    {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::where('institute_id',$institute_id)
                            ->where('course_id',$course_id)
                            ->where('faculty_id',$faculty_id)
                            ->pluck('name', 'id');
        return view('admin.ajax.subjects',['subjects'=>$subjects]);
    }

    public function batch_subjects(Request $request)
    {
        $batch = Batches::where('id',$request->batch_id)->first();

        $subjects = Subjects::where('institute_id',$batch->institute_id)
                            ->where('course_id',$batch->course_id)
                            ->pluck('name', 'id');

        return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects])->render(),), JSON_FORCE_OBJECT);

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

    public function courses_faculties_topics_batches(Request $request)
    {
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $faculties = Faculty::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');
        
        $topics = Topics::get()->where('course_id',$course_id)->pluck('name', 'id');
        
        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->where('branch_id',$branch_id)
            ->pluck('name', 'id');


        //return view('admin.ajax.courses_faculties_batches',['faculties'=>$faculties,'batches'=>$batches]);
        return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties,'batches'=>$batches])->render(),'topics'=>view('admin.ajax.topics',['topics'=>$topics])->render(),'batches'=>view('admin.ajax.courses_batches',['faculties'=>$faculties,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);


    }

    public function courses_subjects_topics_batches(Request $request)
    {
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $subjects = Subjects::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');
        
        $topics = Topics::get()->where('course_id',$course_id)->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->where('branch_id',$branch_id)
            ->pluck('name', 'id');


        return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects,'batches'=>$batches])->render(),'topics'=>view('admin.ajax.topics',['topics'=>$topics])->render(),'batches'=>view('admin.ajax.courses_batches',['subjects'=>$subjects,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

    }

    public function courses_faculties_topics_batches_lectures(Request $request)
    {
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $faculties = Faculty::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');
        
        $topics = Topics::get()->where('course_id',$course_id)->pluck('name', 'id');
        
        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->where('branch_id',$branch_id)
            ->pluck('name', 'id');


        //return view('admin.ajax.courses_faculties_batches',['faculties'=>$faculties,'batches'=>$batches]);
        return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties,'batches'=>$batches])->render(),'topics'=>view('admin.ajax.topics_for_lecture_sheet_batches',['topics'=>$topics])->render(),'batches'=>view('admin.ajax.courses_batches',['faculties'=>$faculties,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);


    }

    public function lecture_videos(Request $request)
    {   
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        if($institute_type)
        {
            $faculties = Faculty::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');
        
            //$lecture_videos = LectureVideo::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');
            
            $lecture_videos = LectureVideo::pluck('name', 'id');
            
            $batches = Batches::where(['institute_id'=>$institute_id,'course_id'=>$course_id,'branch_id'=>$branch_id])->where('course_id',$course_id)->pluck('name', 'id');

            return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties])->render(),'lecture_videos'=>view('admin.ajax.lecture_videos',['lecture_videos'=>$lecture_videos])->render(),'batches'=>view('admin.ajax.courses_batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

        }
        else
        {
            $subjects = Subjects::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');

            //$lecture_videos = LectureVideo::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');
            
            $lecture_videos = LectureVideo::pluck('name', 'id');
            
            $batches = Batches::where(['institute_id'=>$institute_id,'course_id'=>$course_id,'branch_id'=>$branch_id])->where('course_id',$course_id)->pluck('name', 'id');

            return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects])->render(),'lecture_videos'=>view('admin.ajax.lecture_videos',['lecture_videos'=>$lecture_videos])->render(),'batches'=>view('admin.ajax.courses_batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);


        }        

    }

    public function online_exams(Request $request)
    {   
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $institute_type = Institutes::where('id',$institute_id)->first()->type;
        if($institute_type)
        {
            $faculties = Faculty::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');
        
            //$lecture_videos = LectureVideo::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');
            
            $online_exams = OnlineExam::pluck('name', 'id');
            
            $batches = Batches::where(['institute_id'=>$institute_id,'course_id'=>$course_id,'branch_id'=>$branch_id])->where('course_id',$course_id)->pluck('name', 'id');

            return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties])->render(),'online_exams'=>view('admin.ajax.online_exams',['online_exams'=>$online_exams])->render(),'batches'=>view('admin.ajax.courses_batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

        }
        else
        {
            $subjects = Subjects::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');

            //$lecture_videos = LectureVideo::where(['institute_id'=>$institute_id,'course_id'=>$course_id])->pluck('name', 'id');
            
            $online_exams = OnlineExam::pluck('name', 'id');
            
            $batches = Batches::where(['institute_id'=>$institute_id,'course_id'=>$course_id,'branch_id'=>$branch_id])->where('course_id',$course_id)->pluck('name', 'id');

            return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects])->render(),'online_exams'=>view('admin.ajax.online_exams',['online_exams'=>$online_exams])->render(),'batches'=>view('admin.ajax.courses_batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);


        }        

    }

    public function course_changed_in_batch_discipline_fee(Request $request)
    {
        $course = Courses::where('id',$request->course_id)->first();

        $institute_type = Institutes::where('id',$course->institute_id)->first()->type;
        if($institute_type)
        {
            $faculties = Faculty::where(['institute_id'=>$course->institute_id,'course_id'=>$course->id])->pluck('name', 'id');
            $batches = Batches::where('course_id',$course->id)->pluck('name', 'id');
            return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties])->render(),'batches'=>view('admin.ajax.batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

        }
        else
        {
            $subjects = Subjects::where(['institute_id'=>$course->institute_id,'course_id'=>$course->id])->pluck('name', 'id');
            $batches = Batches::where('course_id',$course->id)->pluck('name', 'id');
            return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects])->render(),'batches'=>view('admin.ajax.batches',['batches'=>$batches])->render(),), JSON_FORCE_OBJECT);       

        }    
        
    }

    public function faculty_changed_in_batch_discipline_fee(Request $request)
    {        
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::where('institute_id',$institute_id)
                            ->where('course_id',$course_id)
                            ->where('faculty_id',$faculty_id)
                            ->pluck('name', 'id');
        return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects])->render(),), JSON_FORCE_OBJECT);
    }

    public function course_changed_in_lecture_videos(Request $request)
    {
        $course = Courses::where('id',$request->course_id)->first();

        $institute_type = Institutes::where('id',$course->institute_id)->first()->type;
        if($institute_type)
        {
            $faculties = Faculty::where(['institute_id'=>$course->institute_id,'course_id'=>$course->id])->pluck('name', 'id');
            $topics = Topics::where('course_id',$course->id)->pluck('name', 'id');
            return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties])->render(),'topics'=>view('admin.ajax.topics',['topics'=>$topics])->render(),), JSON_FORCE_OBJECT);

        }
        else
        {
            $subjects = Subjects::where(['institute_id'=>$course->institute_id,'course_id'=>$course->id])->pluck('name', 'id');
            $topics = Topics::where('course_id',$course->id)->pluck('name', 'id');
            return  json_encode(array('subjects'=>view('admin.ajax.subjects_multiple',['subjects'=>$subjects])->render(),'topics'=>view('admin.ajax.topics',['topics'=>$topics])->render(),), JSON_FORCE_OBJECT);       

        }    
        
    }

    public function faculty_changed_in_lecture_videos(Request $request)
    {        
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::where('institute_id',$institute_id)
                            ->where('course_id',$course_id)
                            ->where('faculty_id',$faculty_id)
                            ->pluck('name', 'id');
        return  json_encode(array('subjects'=>view('admin.ajax.subjects_multiple',['subjects'=>$subjects])->render(),), JSON_FORCE_OBJECT);
    }

    public function course_changed_in_online_exams(Request $request)
    {
        $course = Courses::where('id',$request->course_id)->first();

        $institute_type = Institutes::where('id',$course->institute_id)->first()->type;
        if($institute_type)
        {
            $faculties = Faculty::where(['institute_id'=>$course->institute_id,'course_id'=>$course->id])->pluck('name', 'id');
            $topics = Topics::where('course_id',$course->id)->pluck('name', 'id');
            return  json_encode(array('faculties'=>view('admin.ajax.faculties',['faculties'=>$faculties])->render(),'topics'=>view('admin.ajax.topics',['topics'=>$topics])->render(),), JSON_FORCE_OBJECT);

        }
        else
        {
            $subjects = Subjects::where(['institute_id'=>$course->institute_id,'course_id'=>$course->id])->pluck('name', 'id');
            $topics = Topics::where('course_id',$course->id)->pluck('name', 'id');
            return  json_encode(array('subjects'=>view('admin.ajax.subjects_multiple',['subjects'=>$subjects])->render(),'topics'=>view('admin.ajax.topics',['topics'=>$topics])->render(),), JSON_FORCE_OBJECT);       

        }    
        
    }

    public function faculty_changed_in_online_exams(Request $request)
    {        
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        $faculty_id = $request->faculty_id;
        $subjects = Subjects::where('institute_id',$institute_id)
                            ->where('course_id',$course_id)
                            ->where('faculty_id',$faculty_id)
                            ->pluck('name', 'id');
        return  json_encode(array('subjects'=>view('admin.ajax.subjects_multiple',['subjects'=>$subjects])->render(),), JSON_FORCE_OBJECT);
    }


    

    public function courses_subjects_topics_batches_lectures(Request $request)
    {
        $branch_id = $request->branch_id;
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;

        $subjects = Subjects::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');
        
        $topics = Topics::get()->where('course_id',$course_id)->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->where('branch_id',$branch_id)
            ->pluck('name', 'id');


        return  json_encode(array('subjects'=>view('admin.ajax.subjects',['subjects'=>$subjects,'batches'=>$batches])->render(),'topics'=>view('admin.ajax.topics_for_lecture_sheet_batches',['topics'=>$topics])->render(),'batches'=>view('admin.ajax.courses_batches',['subjects'=>$subjects,'batches'=>$batches])->render(),), JSON_FORCE_OBJECT);

    }

    public function courses_faculties_subjects_batches(Request $request)
    {
        $institute_id = $request->institute_id;
        $course_id = $request->course_id;
        // $faculty_id = $request->faculty_id;
        // $subject_id = $request->subject_id;

        $faculties = Faculty::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');
        
        $subjects = Subjects::get()->where('institute_id',$institute_id)
            ->where('course_id',$course_id)
            ->pluck('name', 'id');

        $batches = Batches::get()->where('institute_id',$institute_id)
                                 ->where('course_id',$course_id)
                                 //  ->where('faculty_id',$faculty_id)
                                 //  ->where('subject_id',$subject_id)
                                 ->pluck('name', 'id');
        return array('batches'=>view('admin.ajax.courses_faculties_subjects_batches',['batches'=>$batches]));
    }

    public function reg_no(Request $request)
    {
        $year = $request->year;
        $session = $request->session_id;
        $session = Sessions::where('id',$request->session_id)->pluck('session_code');
        $course_code = Courses::where('id',$request->course_id)->pluck('course_code');
        $batch_code = Batches::where('id',$request->batch_id)->pluck('batch_code');
        $start_index = Batches::where('id',$request->batch_id)->value('start_index');
        $end_index = Batches::where('id',$request->batch_id)->value('end_index');
        $range = 'Batch Range : ( '.$start_index.' - '.$end_index.' ) ';

        $reg_no_first_part = $year.$session[0].substr($course_code[0], 0, 1).substr($batch_code[0], 0, 1);
        
        
        return  json_encode(array('reg_no_first_part'=>$reg_no_first_part,'range'=>$range), JSON_FORCE_OBJECT);

    }

    public function add_schedule_row(Request $request)
    {
        //echo 'Bismillah';exit;
        $data['d'] = $request->d;
        $data['r'] = $request->r;
        $id = $request->schedule_details_id;

        $data['topics_list']= Topics::get()->where('course_id',BatchesSchedules::find($id)->course_id)->sortBy('name')->pluck('name','id');
        $data['teachers_list'] = Teacher::get()->pluck('name','id');
        $data['batch_slots'] = BatchesSchedulesSlots::where('schedule_id',$id)->get();
        $count_slots =  0;
        $m_slot_lists = array();
        $count_rows = count($data['topics_list']);
        $count_slots_all = count($data['batch_slots']);
        foreach ($data['batch_slots'] as $value){
            if ($value['slot_type']){
                $m_slot_lists[++$count_slots] = $value['slot_type'];
            }
        }
        $data['count_slots'] = count($m_slot_lists);
        $data['m_slot_lists'] = $m_slot_lists;
        //echo '<pre>';print_r($data['m_slot_lists']);exit;
        return view('admin.ajax.schedule_row_add',$data);
    }

    public function set_weekday(Request $request){

        $initial_date = date('l',date_create_from_format('Y-m-d',$request->initial_date)->getTimestamp());
        $data['week_days'] = WeekDays::get()->pluck('name', 'wd_id');
        $data['week_day'] = WeekDays::get()->where('name',$initial_date)->pluck('wd_id');
        return view('admin.ajax.select_initial_week_day',$data);

    }

    public function permanent_division_district(Request $request)
    {
        $division_id = $request->permanent_division_id;
        $districts = Districts::get()->where('division_id',$division_id)->pluck('name', 'id');
        return view('admin.ajax.permanent_division_district',['districts'=>$districts]);
    }

    public function permanent_district_upazila(Request $request)
    {
        $district_id = $request->permanent_district_id;
        $upazilas = Upazilas::get()->where('district_id',$district_id)->pluck('name', 'id');
        return view('admin.ajax.permanent_district_upazila',['upazilas'=>$upazilas]);
    }

    public function present_division_district(Request $request)
    {
        $division_id = $request->present_division_id;
        $districts = Districts::get()->where('division_id',$division_id)->pluck('name', 'id');
        return view('admin.ajax.present_division_district',['districts'=>$districts]);
    }

    public function present_district_upazila(Request $request)
    {
        $district_id = $request->present_district_id;
        $upazilas = Upazilas::get()->where('district_id',$district_id)->pluck('name', 'id');
        return view('admin.ajax.present_district_upazila',['upazilas'=>$upazilas]);
    }

    public function search_doctors(Request $request)
    {
        $text =  $_GET['term'];
        $text = $text['term'];

        $data = Doctors::select(DB::raw("CONCAT(name,' - ',bmdc_no) AS name_bmdc"),'id')
            ->where('name', 'like', '%'.$text.'%')
            ->orWhere('bmdc_no', 'like', '%'.$text.'%')
            ->get();
        //$data = DB::table('institution')->where('institution_type_id',$content_section_id)->where('name', 'like', $text.'%')->get();
        echo json_encode( $data);
    }

    public function search_questions(Request $request)
    {
        $text =  $_GET['term'];
        $text = $text['term'];
        $type =  $_GET['type'];

        $data = Question::select('question_title' ,'id')
            ->where('question_title', 'like', '%'.$text.'%')
            ->where('type', $type)
            ->get();
        //$data = DB::table('institution')->where('institution_type_id',$content_section_id)->where('name', 'like', $text.'%')->get();
        echo json_encode( $data);
    }




    public function question_type_mcq_sba(Request $request)
    {
        $question_type_id =  $request->question_type_id;

        $data['question_type'] = QuestionTypes::where('id', $question_type_id)->first();

        return view('admin.ajax.question_type_mcq_sba', $data);
    }

    public function question_info(Request $request)
    {
        $question_type_id =  $request->question_type_id;

        $question_info = QuestionTypes::where('id', $question_type_id)->first();

        $data['total_mcq'] = $question_info->mcq_number;
        $data['total_sba'] = $question_info->sba_number;
        $data['total_mark'] = $question_info->full_mark;
        $data['negative_mark'] = $question_info->negative_mark;
        $data['duration'] = $question_info->duration;

        return view('admin.ajax.question_info', $data);
    }



} 

