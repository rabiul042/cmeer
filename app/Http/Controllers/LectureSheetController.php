<?php

namespace App\Http\Controllers;

use App\BatchesSchedules;
use App\Exam;
use App\Exam_question;
use App\LectureSheetBatch;
use App\OnlineLectureAddress;
use App\OnlineLectureLink;
use App\OnlineExamCommonCode;
use App\OnlineExamLink;
use App\Page;
use App\QuestionTypes;
use App\Result;
use App\Role;
use App\Sessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Doctors;
use App\Courses;
use App\Topics;
use App\DoctorsCourses;
use App\Faculty;
use App\LectureSheet;
use App\LectureSheetLink;
use App\LectureSheetTopics;
use App\Notices;
use Session;
use Validator;

use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class LectureSheetController extends Controller
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
    public function lecture_sheet()
    {        
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['doctor_courses'] = DoctorsCourses::where(['doctor_id'=>$data['doc_info']->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();        
        return view('lecture_sheet', $data);
    }

    public function lecture_topics($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $doctor_course_info = DoctorsCourses::where(['id'=>$id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->first();
        $data['doctor_course_info'] = $doctor_course_info;
        $lecture_sheet_batch_id = LectureSheetBatch::where(['year'=>$doctor_course_info->year,'session_id'=>$doctor_course_info->session_id,'lecture_sheet_batch.institute_id'=>$doctor_course_info->institute_id,'lecture_sheet_batch.course_id'=>$doctor_course_info->course_id,'batch_id'=>$doctor_course_info->batch_id])->value('id');
        $lecture_sheet_batch = LectureSheetBatch::where(['year'=>$doctor_course_info->year,'session_id'=>$doctor_course_info->session_id,'lecture_sheet_batch.institute_id'=>$doctor_course_info->institute_id,'lecture_sheet_batch.course_id'=>$doctor_course_info->course_id,'batch_id'=>$doctor_course_info->batch_id])
            ->join('lecture_sheet_topics','lecture_sheet_topics.lecture_sheet_batch_id','lecture_sheet_batch.id')
            ->join('topics','topics.id','lecture_sheet_topics.topic_id')
            ->join('lecture_sheet_post','lecture_sheet_post.topic_id','topics.id')
            ->paginate(10);
        $data['lecture_sheet_batch'] = $lecture_sheet_batch;
        $data['lecture_sheet_batch_id'] = $lecture_sheet_batch_id;
        $data['lecture_sheet_topics'] = LectureSheetTopics::where('lecture_sheet_batch_id',$lecture_sheet_batch_id)->join('topics','topics.id','lecture_sheet_topics.topic_id')->pluck('topics.name', 'topics.id');
        return view('lecture_topics',$data);
    }

    public function lecture_details($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['doctor_course_info'] = DoctorsCourses::where(['id'=>$id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->first();
        $data['lecture_sheet'] = LectureSheet::where('id',$id)->first();
        $data['lecture_sheets'] = LectureSheet::where('topic_id',$data['lecture_sheet']->topic_id)->get();
        return view('lecture_details',$data);
    }

    public function topic_lecture_sheets(Request $request)
    {
        $lecture_sheet_batch_id = $request->lecture_sheet_batch_id;
        $topic_id = $request->topic_id;

        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
                
        $lecture_sheet_batch = LectureSheet::where(['topic_id'=>$topic_id])
            ->paginate(10);
        $data['lecture_sheet_batch'] = $lecture_sheet_batch;
        $data['lecture_sheet_batch_id'] = $lecture_sheet_batch_id;
        $data['topic'] = Topics::where('id',$topic_id)->first();
        $data['lecture_sheet_topics'] = LectureSheetTopics::where('lecture_sheet_batch_id',$lecture_sheet_batch_id)->join('topics','topics.id','lecture_sheet_topics.topic_id')->pluck('topics.name', 'topics.id');
        //echo '<pre>';print_r($data['topic']);exit;
        return view('topic_lecture_sheets',$data);
    }



    public function lecture_video()
    {

        $doc_info = Doctors::where('id', Auth::id())->first();
        $doctor_courses = DoctorsCourses::where('doctor_id',$doc_info->id)->get();

        $data['doc_info'] = $doc_info;
        $data['doctor_courses'] = $doctor_courses;
        $online_lecture_links = array();
        foreach($doctor_courses as $key=>$doctor_course){
            $exam_comm_code_ids = OnlineLectureLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'institute_id'=>$doctor_course->institute_id,'course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->pluck('lecture_address_id');

            foreach ($exam_comm_code_ids as $id){
                $online_lecture_links[$doctor_course->reg_no][] =  OnlineLectureAddress::select('*')->where('id',$id)->get();
            }
        }
        $data['online_lecture_links'] = $online_lecture_links;
        $data['rc'] = '';
        $data['video_link'] = OnlineLectureAddress::select('*')->where('status', 1)->get();
        return view('lecture/lecture_video', $data);

    }




















}
