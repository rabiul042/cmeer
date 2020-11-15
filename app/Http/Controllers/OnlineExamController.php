<?php

namespace App\Http\Controllers;

use App\BatchesSchedules;
use App\Exam;
use App\Exam_question;

use App\OnlineLectureAddress;
use App\OnlineLectureLink;
use App\OnlineExamCommonCode;
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
use App\OnlineExam;
use App\OnlineExamLink;
use App\OnlineExamTopics;
use Jenssegers\Agent\Agent;
use App\Notices;
use Session;
use Validator;

use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class OnlineExamController extends Controller
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
    public function online_exams()
    {        
        $doc_info = Doctors::where('id', Auth::id())->first();
        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();

        $data['doc_info'] = $doc_info;
        $data['doctor_courses'] = $doctor_courses;
        $exam_link_ids = array();
        foreach($doctor_courses as $key=>$doctor_course){

            if(OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->first()){

                $exam_link_ids[] = OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->value('id');
                
            }
              
            
        } 
        
        // $online_exam_batch = OnlineExamLink::whereIn('online_exam_batch.id',$exam_link_ids)
        //     ->join('online_exam_batch_online_exam','online_exam_batch_online_exam.online_exam_batch_id','online_exam_batch.id')
        //     ->join('online_exam','online_exam.id','online_exam_batch_online_exam.online_exam_id')            
        //     ->paginate(10); 
        
        //$data['online_exam_batch'] = $online_exam_batch;

        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();
        $doctor_courses_with_exam = array();
        foreach($doctor_courses as $key=>$doctor_course){

            if(OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->first()){
                $doctor_courses_with_exam[] = $doctor_course;
            }

        }

        $data['doctor_courses'] = $doctor_courses_with_exam;

        return view('online_exam/lecture_topics',$data);

    }

    public function doctor_course_online_exam($doctor_course_id)
    {        
        $doc_info = Doctors::where('id', Auth::id())->first();
        $doctor_courses = DoctorsCourses::where(['id'=>$doctor_course_id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();

        $data['doc_info'] = $doc_info;
        $data['doctor_courses'] = $doctor_courses;
        $data['doctor_course'] = $doctor_courses[0];
        $exam_link_ids = array();
        foreach($doctor_courses as $key=>$doctor_course){

            if(OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->first()){
                
                $exam_link_ids[] = OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->value('id');
                
            }
            
        }

        //echo "<pre>";print_r($exam_link_ids);exit;

        if($doctor_courses[0]->batch->fee_type == "Batch")
        {
            $online_exam_batch = OnlineExamLink::whereIn('online_exam_batch.id',$exam_link_ids)
            ->join('online_exam_batch_online_exam','online_exam_batch_online_exam.online_exam_batch_id','online_exam_batch.id')
            ->join('online_exam','online_exam.id','online_exam_batch_online_exam.online_exam_id')            
            ->paginate(10); 

        }
        else if($doctor_courses[0]->batch->fee_type == "Discipline")
        {
            $online_exam_batch = OnlineExamLink::select('online_exam.*')->whereIn('online_exam_batch.id',$exam_link_ids)->where('online_exam_discipline.subject_id',$doctor_courses[0]->subject_id)
            ->join('online_exam_batch_online_exam','online_exam_batch_online_exam.online_exam_batch_id','online_exam_batch.id')
            ->join('online_exam','online_exam.id','online_exam_batch_online_exam.online_exam_id')            
            ->join('online_exam_discipline','online_exam_discipline.online_exam_id','online_exam.id')
            //->join('batch_discipline_fees','batch_discipline_fees.batch_id','online_exam_batch.batch_id')
            ->paginate(10);

        }
        
        //echo "<pre>";print_r($online_exam_batch);exit;

        
        $data['online_exam_batch'] = $online_exam_batch;
        
        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();
        $doctor_courses_with_exam = array();
        foreach($doctor_courses as $key=>$doctor_course){ 

            if(OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->first()){
                $doctor_courses_with_exam[] = $doctor_course;
            }

        }

        $data['doctor_courses'] = $doctor_courses_with_exam;

        return view('online_exam/lecture_topics',$data);

    }

    public function online_exam($course_id,$batch_id)
    {        
        $doc_info = Doctors::where('id', Auth::id())->first();
        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'course_id'=>$course_id,'batch_id'=>$batch_id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();

        $data['doc_info'] = $doc_info;
        $data['doctor_courses'] = $doctor_courses;
        $exam_link_ids = array();
        foreach($doctor_courses as $key=>$doctor_course){

            if(OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->first()){
                
                $exam_link_ids[] = OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->value('id');
                
            }
            
        }

        //echo "<pre>";print_r($exam_link_ids);exit;

        if($doctor_courses[0]->batch->fee_type == "Batch")
        {
            $online_exam_batch = OnlineExamLink::whereIn('online_exam_batch.id',$exam_link_ids)
            ->join('online_exam_batch_online_exam','online_exam_batch_online_exam.online_exam_batch_id','online_exam_batch.id')
            ->join('online_exam','online_exam.id','online_exam_batch_online_exam.online_exam_id')            
            ->paginate(10); 

        }
        else if($doctor_courses[0]->batch->fee_type == "Discipline")
        {
            $online_exam_batch = OnlineExamLink::whereIn('online_exam_batch.id',$exam_link_ids)->where('online_exam_discipline.subject_id',$doctor_courses[0]->subject_id)
            ->join('online_exam_batch_online_exam','online_exam_batch_online_exam.online_exam_batch_id','online_exam_batch.id')
            ->join('online_exam','online_exam.id','online_exam_batch_online_exam.online_exam_id')            
            ->join('online_exam_discipline','online_exam_discipline.online_exam_id','online_exam.id')
            //->join('batch_discipline_fees','batch_discipline_fees.batch_id','online_exam_batch.batch_id')
            ->paginate(10);

        }
        
        //echo "<pre>";print_r($online_exam_batch);exit;

        
        $data['online_exam_batch'] = $online_exam_batch;
        
        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();
        $doctor_courses_with_exam = array();
        foreach($doctor_courses as $key=>$doctor_course){

            if(OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->first()){
                $doctor_courses_with_exam[] = $doctor_course;
            }

        }

        $data['doctor_courses'] = $doctor_courses_with_exam;

        return view('online_exam/lecture_topics',$data);

    }

    public function lecture_topics($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $doctor_course_info = DoctorsCourses::where('id', $id)->first();
        $data['doctor_course_info'] = $doctor_course_info;
        $online_exam_batch_id = OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->value('id');
        $online_exam_batch = OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'online_exam_batch.institute_id'=>$doctor_course->institute_id,'online_exam_batch.course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])
            ->join('online_exam_topics','online_exam_topics.online_exam_batch_id','online_exam_batch.id')
            ->join('topics','topics.id','online_exam_topics.topic_id')
            ->join('online_exam_post','online_exam_post.topic_id','topics.id')
            ->paginate(10);
        $data['online_exam_batch'] = $online_exam_batch;
        $data['online_exam_batch_id'] = $online_exam_batch_id;
        $data['online_exam_topics'] = OnlineExamTopics::where('online_exam_batch_id',$online_exam_batch_id)->join('topics','topics.id','online_exam_topics.topic_id')->pluck('topics.name', 'topics.id');
        return view('lecture_topics',$data);
    }

    public function lecture_details($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['doctor_course_info'] = DoctorsCourses::where('id', $id)->first();
        $data['online_exam'] = OnlineExam::where('id',$id)->first();
        $data['online_exams'] = OnlineExam::where('topic_id',$data['online_exam']->topic_id)->get();
        return view('lecture_details',$data);
    }

    public function online_exam_details($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['doctor_course_info'] = DoctorsCourses::where('id', $data['doc_info']->id)->first();
        $data['link'] = OnlineExam::where('id',$id)->first();
        $agent =  new Agent();
        $data['browser'] = $agent->browser();
        return view('online_exam/lecture_details',$data);
    }

    public function topic_online_exams(Request $request)
    {
        $online_exam_batch_id = $request->online_exam_batch_id;
        $topic_id = $request->topic_id;

        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
                
        $online_exam_batch = OnlineExam::where(['topic_id'=>$topic_id])
            ->paginate(10);
        $data['online_exam_batch'] = $online_exam_batch;
        $data['online_exam_batch_id'] = $online_exam_batch_id;
        $data['topic'] = Topics::where('id',$topic_id)->first();
        $data['online_exam_topics'] = OnlineExamTopics::where('online_exam_batch_id',$online_exam_batch_id)->join('topics','topics.id','online_exam_topics.topic_id')->pluck('topics.name', 'topics.id');
        //echo '<pre>';print_r($data['topic']);exit;
        return view('topic_online_exams',$data);
    }



    public function online_examoo()
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
        $data['exam_link'] = OnlineLectureAddress::select('*')->where('status', 1)->get();
        return view('lecture/online_exam', $data);

    }




















}
