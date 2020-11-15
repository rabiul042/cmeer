<?php

namespace App\Http\Controllers;

use App\BatchesSchedules;
use App\Exam;
use App\Exam_question;
use App\OnlineLectureAddress;
use App\OnlineLectureLink;
use App\OnlineExamCommonCode;
use App\OnlineExamLink;
use App\Page;
use App\QuestionTypes;
use App\Result;
use App\Sessions;
use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Doctors;
use App\Mail\Send_Mail;
use Mail;
use App\Batches;
use App\Courses;
use App\DoctorsCourses;
use App\DoctorQuestion;
use App\DoctorQuestionReply;
use App\DoctorComplain;
use App\DoctorComplainReply;
use App\Faculty;
use App\Notices;
use App\DoctorNotices;
use App\Otp;
use App\PaymentInfo;
use App\Institutes;
use App\LectureVideo;
use App\Divisions;
use App\Districts;
use App\Upazilas;
use App\MedicalColleges;

use Jenssegers\Agent\Agent;
use Session;
use Validator;

use Auth;
use Illuminate\Support\Facades\Hash;

use App\DoctorAsks;
use App\DoctorAskReply;
use App\DoctorCoursePayment;
use App\DoctorEducations;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class HomeController extends Controller
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
    public function index()
    {
       // $agent =  new Agent();
        //echo $agent->browser();exit;

        return view('home');
    }

    public function gallery()
    {
        return view('gallery');
    }



    public function course_code_batch_code()
    {
        $coures = Courses::select('*')
            ->get();

        foreach ($coures as $row){
            DoctorsCourses::where('course_i', $row->course_code)
                ->update(['course_id' => $row->id]);
        }

        $faculty = Faculty::select('*')
            ->get();

        foreach ($faculty as $row){
            DoctorsCourses::where('faculty_id', $row->faculty_code)
                ->update(['faculty_id' => $row->id]);
        }

    }


    public function questions()
    {
        $doctors = DoctorsCourses::select('id','bmdc_no')
            ->get();
        foreach ($doctors as $row){
            DoctorsCourses::where('bmdc_no', $row->bmdc_no)
                ->update(['doctor_id' => $row->id]);
        }
    }






//Doctor Profile Links Start

    public function my_profile()
    {
        
        // if(Auth::user()->father_name && Auth::user()->mother_name){
        //    if(!DoctorEducations::where('doctor_id', Auth::id())->count()){
        //        return redirect('register-third-step/'.Auth::id());
        //    }
        
        // }else{
        //     return redirect('register-second-step/'.Auth::id());
        // }
        
        $doc_info = Doctors::where('id', Auth::id())->first();
        $data['doctors_education'] = DoctorEducations::where('doctor_id',Auth::id())->get();
        foreach($doc_info->doctorcourses as $single){
            $doc_info->schedule_id = BatchesSchedules::where(['year'=>$single->year,'session_id'=>$single->session_id,'course_id'=>$single->course_id])->value('id');
        }
        $data['doc_info'] = $doc_info;
        return view('my_profile', $data);
    }

    public function edit_profile($id)
    {
        $data['doc_info'] = Doctors::where('id',$id)->first();
        $data['medical_colleges'] = MedicalColleges::orderBy('name')->pluck('name','id');
        $data['doctors_education'] = DoctorEducations::where('doctor_id',Auth::id())->first();
        $data['ssc'] = DoctorEducations::where(['doctor_id'=>$id,'exam'=>'SSC'])->first();
        $data['hsc'] = DoctorEducations::where(['doctor_id'=>$id,'exam'=>'HSC'])->first();
        $data['mbbs_bds'] = DoctorEducations::where(['doctor_id'=>$id,'exam'=>'MBBS/BDS'])->first();
        $data['post_graduation'] = DoctorEducations::where(['doctor_id'=>$id,'exam'=>'Post-Graduation'])->first();
        $data['divisions'] = Divisions::pluck('name', 'id');
        $data['present_districts'] = Districts::where(['division_id'=>$data['doc_info']->present_division_id])->pluck('name', 'id');
        $data['present_upazilas'] = Upazilas::where(['district_id'=>$data['doc_info']->present_district_id])->pluck('name', 'id');
        $data['permanent_districts'] = Districts::where(['division_id'=>$data['doc_info']->permanent_division_id])->pluck('name', 'id');
        $data['permanent_upazilas'] = Upazilas::where(['district_id'=>$data['doc_info']->permanent_district_id])->pluck('name', 'id');
        
        return view('edit_profile', $data);
    }

    public function update_profile(Request $request)
    {
        $profile = Doctors::find(Auth::id());
        $profile->name=$request->doc_name;
        $profile->bmdc_no=$request->bmdc_no;
        $profile->father_name=$request->father_name;
        $profile->mother_name=$request->mother_name;
        $profile->mobile_number=$request->mobile_number;
        $profile->email=$request->email;
        $profile->medical_college_id=$request->medical_college_id;

        if ($request->file('image')){
            $file=$request->file('image');
            $fileName = md5(uniqid(rand(), true)).'.'.strtolower(pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION)) ;
            $destinationPath = 'store/' ;
            $file->move($destinationPath,$fileName);
            $profile->photo = $destinationPath.$fileName;
        }

        $profile->gender=$request->gender;
        $profile->date_of_birth=$request->date_of_birth;
        $profile->job_description=$request->job_description;
        $profile->nid=$request->nid;
        // $profile->passport=$request->passport;
        $profile->main_password=$request->main_password;
        $profile->password=Hash::make($request->password);
        $profile->present_division_id = $request->present_division_id;
        $profile->present_district_id = $request->present_district_id;
        $profile->present_upazila_id = $request->present_upazila_id;
        $profile->present_address = $request->present_address;
        $profile->permanent_division_id = $request->permanent_division_id;
        $profile->permanent_district_id = $request->permanent_district_id;
        $profile->permanent_upazila_id = $request->permanent_upazila_id;
        $profile->permanent_address = $request->permanent_address;
        $profile->push();

        // dd($request->board );
        DoctorEducations::where('doctor_id', Auth::id())->delete();

        foreach($request->exam as $k => $value){


            $doctors_education = new DoctorEducations();
            $doctors_education->exam = $value;
            $doctors_education->doctor_id = Auth::id();
            $doctors_education->board = $request->board[$k]??'';
            $doctors_education->result = $request->result[$k]??'';
            $doctors_education->passing_year = $request->year[$k]??'';
            $doctors_education->roll = $request->roll[$k]??'';
            $doctors_education->duration = $request->duration[$k]??'';





        $doctors_education->push();
        

        }
        //return back();
        Session::flash('message', 'Record has been updated successfully');

        $doc_info = Doctors::where('id', Auth::id())->first();
        foreach($doc_info->doctorcourses as $single){
            $doc_info->schedule_id = BatchesSchedules::where(['year'=>$single->year,'session_id'=>$single->session_id,'course_id'=>$single->course_id])->value('id');
        }
        $data['doc_info'] = $doc_info;
        return redirect('my-profile');
    }


    public function my_courses()
    {
        $doc_info = Doctors::where('id', Auth::id())->first();
        foreach($doc_info->doctorcourses as $single){
            $doc_info->schedule_id = BatchesSchedules::where(['year'=>$single->year,'session_id'=>$single->session_id,'course_id'=>$single->course_id,'batch_id'=>$single->batch_id])->value('id');
        }
        $data['doc_info'] = $doc_info;
        return view('my_courses', $data);
    }

    public function  edit_doctor_course_discipline($doctor_course_id){

        $data['doctor_course'] = DoctorsCourses::where('id',$doctor_course_id)->get();
        $doctor_course = $data['doctor_course'];

        $data['institute_type'] = Institutes::where('id',$doctor_course->institute_id)->first()->type;

        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$doctor_course->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$doctor_course->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$doctor_course->course_id)->pluck('name', 'id');
        }

        return view('edit_doctor_course_discipline',$data);

    }

    public function  update_doctor_course_discipline(Request $request, $id){

            $validator = Validator::make($request->all(), [
                'doctor_id' => ['required'],
                'institute_id' => ['required'],
                'course_id' => ['required'],
            ]);

            if ($validator->fails()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','Please enter proper input values!!!');
                return redirect()->action('HomeController@edit_doctor_course_discipline',[$id])->withInput();
            }

            $doctor_course = DoctorsCourses::find($id);

            $doctor_course->doctor_id = $request->doctor_id;

            $doctor_course->institute_id = $request->institute_id;
            $doctor_course->course_id = $request->course_id;
            $doctor_course->faculty_id = $request->faculty_id;
            $doctor_course->subject_id = $request->subject_id;

            $doctor_course->updated_by = Auth::id();

            $doctor_course->push();

            Session::flash('message', 'Record has been updated successfully');

            return redirect()->action('HomeController@edit_doctor_course_discipline',[$id]);

        }

    public function payment_details()
    {
        $doc_info = Doctors::where('id', Auth::id())->first();
        $data['paid_amount'] = 0;
        $data['total_row'] = 0;
        $data['doc_info'] = $doc_info;
        $data['course_info'] = DoctorsCourses::where(['doctor_id'=>$doc_info->id])->get();
        $last_reg = DoctorsCourses::select('*')->where('doctor_id', $doc_info->id)->orderBy('id', 'desc')->limit(1)->first();
        $data['last_reg'] = $last_reg;
        
        if(isset($last_reg->batch_id)){
            $data['last_reg_pay'] = Batches::select('*')->where('id', $last_reg->batch_id)->first();
        } else {
            $data['last_reg_pay'] = '';
        }
        
        return view('payment_details', $data);
    }

    public function evaluate_teacher()
    {        
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        return view('evaluate_teacher', $data);
    }

    public function online_exam()
    {

        $doc_info = Doctors::where('id', Auth::id())->first();
        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();
        //echo '<pre>';print_r($doc_courses);exit;
        foreach($doc_info->doctorcourses as $single){
            $doc_info->schedule_id = BatchesSchedules::where(['year'=>$single->year,'session_id'=>$single->session_id,'course_id'=>$single->course_id])->value('id');
        }
        $data['doc_info'] = $doc_info;
        $data['doctor_courses'] = $doctor_courses;
        $online_exam_links = array();
        foreach($doctor_courses as $key=>$doctor_course){
            $exam_comm_code_ids = OnlineExamLink::where(['year'=>$doctor_course->year,'session_id'=>$doctor_course->session_id,'institute_id'=>$doctor_course->institute_id,'course_id'=>$doctor_course->course_id,'batch_id'=>$doctor_course->batch_id])->pluck('exam_comm_code_id');
            foreach ($exam_comm_code_ids as $id){
                $online_exam_links[$doctor_course->reg_no][] =  OnlineExamCommonCode::where('id',$id)->value('exam_comm_code');
            }
        }
        $data['online_exam_links'] = $online_exam_links;
        return view('online_exam', $data);

    }

    public function online_lecture()
    {
        
        $doc_info = Doctors::where('id', Auth::id())->first();
        $doctor_courses = DoctorsCourses::where(['doctor_id'=>$doc_info->id,'is_trash'=>'0'])->where('payment_status', '!=' , 'No Payment')->get();
        
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
        $agent =  new Agent();
        $data['browser'] = $agent->browser();
        return view('online_lecture', $data);

    }

    public function doctor_admission()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        return view('doctor_admission', $data);
    }

    public function doctor_result()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['course_info'] = DoctorsCourses::select('*')->where('doctor_id', Auth::id())->get();
        return view('result', $data);
    }

    public function course_result($id)
    {
        $data['course_id'] = $id;
        $data['course_reg_no'] = DoctorsCourses::select('*')->where('id', $id)->first();
        $data['results'] = Result::select('*')->where('doctor_course_id', $id)->get();
        return view('course_result', $data);
    }


    public function result()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        return view('result', $data);
    }

    public function schedule()
    {        
        $doc_info = Doctors::where('id', Auth::id())->first();
        
        foreach($doc_info->doctorcourses as $single){ // "<pre>";print_r($single->session->name);
            $single->schedule = BatchesSchedules::where(['year'=>$single->year,'session_id'=>$single->session_id,'course_id'=>$single->course_id,'batch_id'=>$single->batch_id])->first();
        }//exit;
        $data['doc_info'] = $doc_info;
        return view('schedule', $data);        
    }

    public function notice()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['notices'] = Notices::where('status', 1)->orderBy('id', 'desc')->get();
        $data['doctor_notices'] = DoctorNotices::where('doctor_id', Auth::id())->get();
        $data['batch_notices'] = DoctorsCourses::where('doctor_id', Auth::id())->get();
        return view('notice', $data);
    }

    public function notice_details($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['id'] = $id;
        $notice = Notices::where('id', $id)->first();
        $data['notices'] = Notices::where('id', $id)->first();

        if ($notice->type=='I'){
            $data['doctors'] = DoctorNotices::where('notice_id', $id)->where('doctor_id', Auth::id())->get();
        }

        return view('notice_details', $data);
    }

    public function change_password()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['notices'] = Notices::where('status', 1)->orderBy('id', 'desc')->get();
        return view('change_password', $data);
    }

    public function update_password(Request $request)
    {
        if($request->new_password==$request->confirm_password){
            $profile = Doctors::find(Auth::id());
            $profile->main_password=$request->new_password;
            $profile->password=Hash::make($request->new_password);
            $profile->push();
            Session::flash('message', 'Password has been updated successfully');

            return back();
        } else {
            Session::flash('message', 'Password NOT updated!');

            return back();
        }
    }



    public function question_box()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['question_info'] = DoctorAsks::where('doctor_id', Auth::id())->get();
        return view('question_box', $data);
    }

    public function question_add()
    {
        $doc_info = Doctors::where('id', Auth::id())->first();
        foreach($doc_info->doctorcourses as $single){
            $doc_info->schedule_id = BatchesSchedules::where(['year'=>$single->year,'session_id'=>$single->session_id,'course_id'=>$single->course_id,'batch_id'=>$single->batch_id])->value('id');
        }
        $data['doc_info'] = $doc_info;

        return view('question_add', $data);

    }

    public function submit_question(Request $request)
    {
        if ($request->description) {
            $question = new DoctorQuestion();
            $question->doctor_id = Auth::id();
            $question->batch_id = $request->batch_id;
            $question->lecture_id = $request->lecture_id;
            $question->question = $request->description;
            $question->status = 1;
            $question->save();
            Session::flash('message', 'Question Uploaded successfully');
            return back();
        } else {
            Session::flash('message', 'Question NOT Uploaded!');
            return back();
        }
    }

    public function question_delete($id)
    {
        if($id){
            $question = DoctorQuestion::find($id);
            $question->status=0;
            $question->push();
            Session::flash('message', 'Question Deleted successfully');
            return back();
        } else {
            Session::flash('message', 'NOT Deleted!');
            return back();
        }
    }

    public function complain_box()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['complain_info'] = DoctorComplain::where('doctor_id', Auth::id())->orderBy('id', 'asc')->get();
            if (DoctorComplain::where(['doctor_id'=>Auth::id()])->exists()){
                $complain_id = DoctorComplain::where(['doctor_id'=>Auth::id()])->first();
                return redirect('complain-details/'.$complain_id->id);
            }
        return view('complain_box', $data);
    }

    public function submit_complain(Request $request)
    {
        if ($request->description) {
            
            if (DoctorComplain::where(['doctor_id'=>Auth::id()])->exists()){
                $complain_id = DoctorComplain::where(['doctor_id'=>Auth::id()])->first();
                $complain_submit = new DoctorComplainReply();
                $complain_submit->doctor_id = Auth::id();
                $complain_submit->user_id = 0;
                $complain_submit->message_by = 'doctor';
                $complain_submit->message = $request->description;
                $complain_submit->doctor_complain_id = $complain_id->id;
                $complain_submit->is_read = 'No';
                $complain_submit->save();
                return redirect('complain-details/'.$complain_id->id);
            }

            $complain = new DoctorComplain();
            $complain->doctor_id = Auth::id();
            $complain->save();

            $complain_submit = new DoctorComplainReply();
            $complain_submit->doctor_id = Auth::id();
            $complain_submit->user_id = 0;
            $complain_submit->message_by = 'doctor';
            $complain_submit->message = $request->description;
            $complain_submit->doctor_complain_id = $complain->id;
            $complain_submit->is_read = 'No';
            $complain_submit->save();

            Session::flash('message', 'Complain submited successfully');
            return back();
        } else {
            Session::flash('message', 'Complain NOT submited!');
            return back();
        }
    }

    public function complain_details($id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['complain_details'] = DoctorComplainReply::where('doctor_complain_id', $id)->orderBy('id', 'ASC')->get();
        $data['complain_id'] = $id;
        return view('complain_details', $data);
    }

     public function complain_again(Request $request)
    {
        if ($request->description) {
            $complain_again = new DoctorComplainReply();
            $complain_again->doctor_id = Auth::id();
            $complain_again->user_id = 0;
            $complain_again->message_by = 'doctor';
            $complain_again->message = $request->description;
            $complain_again->doctor_complain_id = $request->complain_id;
            $complain_again->is_read = 'No';
            $complain_again->save();

            Session::flash('message', 'Complain Submit successfully');
            return back();
        } else {
            Session::flash('message', 'NOT Submited!');
            return back();
        }
    }

    public function send_otp(Request $request)
    {
        if (Auth::id()) {
            $data['doc_info'] = Doctors::where('id', Auth::id())->first();
            if(($request->doctor_id!='') && ($request->video_id!='')){
                $otp_info = Otp::where('doctor_id', $request->doctor_id)->where('video_id', $request->video_id)->first();
                if($otp_info){
                    if(($otp_info->status==1) || ($otp_info->status==2) || ($otp_info->status==3)){
                        echo 1;
                        $otp_pass=rand(1234,9876);
                        $otp_upd = Otp::find($otp_info->id);
                        $otp_upd->otp=$otp_pass;
                        $otp_upd->push();
                    
                        $mob = '88'.$request->phone;
                        $msg = 'Your OTP is : '.$otp_pass;
                        $msg = str_replace(' ', '%20', $msg);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://sms4.digitalsynapsebd.com/api/mt/SendSMS?user=genesispg&password=123321&senderid=8801833307423&channel=Normal&DCS=0&flashsms=0&number=$mob&text=$msg");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_exec($ch);
                        curl_close($ch);
                        $data['video_id'] = $request->video_id;
                        $data['msg'] = 'OTP Sent to Your Mobile ('.$request->phone.') by SMS';
                        return view('otp_view', $data);

                    } else {
                        echo "You have Used OTP 3 times for this video.";
                    }
                    

                } else {

                    $otp_pass=rand(1234,9876);
                    $otp = new Otp();
                    $otp->doctor_id = $request->doctor_id;
                    $otp->video_id = $request->video_id;
                    $otp->otp = $otp_pass;
                    $otp->status = 1;
                    $otp->save();
                    
                    $mob = '88'.$request->phone;
                    $msg = 'Your OTP is : '.$otp_pass;
                    $msg = str_replace(' ', '%20', $msg);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://sms4.digitalsynapsebd.com/api/mt/SendSMS?user=genesispg&password=123321&senderid=8801833307423&channel=Normal&DCS=0&flashsms=0&number=$mob&text=$msg");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                    curl_exec($ch);
                    curl_close($ch);
                    $data['video_id'] = $request->video_id;
                    $data['msg'] = 'OTP Sent to Your Mobile ('.$request->phone.') by SMS';
                    return view('otp_view', $data);
                }

            } else {
                Session::flash('message', 'Data Missing!');
                return back();
            }
        } else {
            return view('/home');
        }
    
    }

    public function submit_otp(Request $request)
    {
        if (Auth::id()) {
            $data['doc_info'] = Doctors::where('id', Auth::id())->first();
            
            if(($request->doctor_id!='') && ($request->video_id!='') && ($request->otp!='')){
                
                $data['doctor_id']  = $request->doctor_id;
                $data['video_id']   = $request->video_id;
                $otp                = $request->otp;

                $otp_info = Otp::where('doctor_id', $request->doctor_id)->where('video_id', $request->video_id)->where('otp', $request->otp)->orderBy('id', 'DESC')->first();

                if ($otp_info){
                    if(($otp_info->status==1) || ($otp_info->status==2) || ($otp_info->status==3)){
                        $data['otp_status']=1;
                        $data['video_info'] = OnlineLectureAddress::select('*')->where('id', $request->video_id)->get();
                        if($otp_info->status==1){
                            $otp_sts=2;
                        } elseif ($otp_info->status==2) {
                            $otp_sts=3;
                        } else {
                            $otp_sts=0;
                        }
                        $otp_upd = Otp::find($otp_info->id);
                        $otp_upd->status=$otp_sts;
                        $otp_upd->push();
                    } else {
                        $data['otp_status']=0;
                    }
                } else {
                    $data['otp_status']=4;
                }

                return view('otp_submit', $data);

            } else {
                Session::flash('message', 'Data Missing');
                return back();
            }

        } else {
            return view('/home');
        }

    }


    public function pay_now(Request $request)
    {
        if ($request->amount) {
            $time = substr(time(), -4); 
            $trans_id = date('ymd').'_'.$time.rand(12,34).rand(56,78);
            $pay_now = new PaymentInfo();
            $pay_now->doctor_id = Auth::id();
            $pay_now->doctor_course_id = $request->doctor_course_id;
            $pay_now->trans_id = $trans_id;
            $pay_now->amount = $request->amount;
            $pay_now->status = 0;
            $pay_now->save();
            $payment_id = $pay_now->id;
            $doc_info = Doctors::where('id', Auth::id())->first();
            echo $link = "https://banglamedexam.com/user-login-sif-payment?
            name=$doc_info->name&
            password=123456&
            email=$doc_info->email&
            bmdc=$doc_info->bmdc_no&
            phone=$doc_info->mobile_number&
            doctor_id=$doc_info->id&
            regi_no=$request->reg_no&
            trans_id=$trans_id&
            payment_id=$payment_id&
            amount=$request->amount";
            return redirect($link);
            
        } else {
            Session::flash('message', ' NOT submited!');
            return back();
        }
    }

    // public function payment_success(Request $request)
    // {
    //     if (Auth::id()) {
    //         $data['doc_info'] = Doctors::where('id', Auth::id())->first();

    //         if ((isset($_GET['doctor_course_id'])) && (isset($_GET['trans_id']))){
    //             $payment_id = $_GET['payment_id'];
    //             $paid = PaymentInfo::find($payment_id);
    //             $paid->status=1;
    //             $paid->push();
    //             //Session::flash('status', ' Payment Success!');
    //             return view('my_courses', $data);

    //         }
    //     }
        
    // }

    // public function payment_success(Request $request)
    // {
    //     if (Auth::id()) {
    //         $data['doc_info'] = Doctors::where('id', Auth::id())->first();

            

    //         if ((isset($_GET['doctor_course_id'])) && (isset($_GET['trans_id'])) && (isset($_GET['amount']))){
    //             $doctor_course_id = $_GET['doctor_course_id'];
    //             $trans_id = $_GET['trans_id'];
    //             $amount = $_GET['amount'];
    //             $payment_serial = $_GET['payment_serial'];

    //             if (DoctorCoursePayment::where(['trans_id'=>$trans_id])->exists()){
                     
    //                 $course_fee = DoctorsCourses::select('*')->where('id', $doctor_course_id)->first();
                
    //                 $paid_amount = 0;
    //                 $paid = DoctorCoursePayment::select('*')->where('doctor_course_id', $doctor_course_id)->get();
    //                 foreach ($paid as $key => $value) {
    //                     $paid_amount = $paid_amount+$value->amount;
    //                 }

    //                 if ($course_fee->course_price==$paid_amount) {
    //                     $payment_status = DoctorsCourses::find($doctor_course_id);
    //                     $payment_status->payment_status='Completed';
    //                     $payment_status->push();
    //                     Session::flash('status', ' Payment Success!');
    //                     return redirect('payment-details');
    //                 } else {
    //                     $payment_status = DoctorsCourses::find($doctor_course_id);
    //                     $payment_status->payment_status='In Progress';
    //                     $payment_status->push();
    //                     Session::flash('status', ' Payment Success!');
    //                     return redirect('payment-details');
    //                 }

    //                 Session::flash('status', ' Payment Success!');
    //                 return redirect('payment-details');
    //             }

    //             $pay_now = new DoctorCoursePayment();
    //             $pay_now->doctor_course_id = $doctor_course_id;
    //             $pay_now->trans_id = $trans_id;
    //             $pay_now->amount = $amount;
    //             $pay_now->payment_serial = $payment_serial;
    //             $pay_now->save();

    //             $course_fee = DoctorsCourses::select('*')->where('id', $doctor_course_id)->first();
                
    //             $paid_amount = 0;
    //             $paid = DoctorCoursePayment::select('*')->where('doctor_course_id', $doctor_course_id)->get();
    //             foreach ($paid as $key => $value) {
    //                 $paid_amount = $paid_amount+$value->amount;
    //             }

    //             if ($course_fee->course_price==$paid_amount) {
    //                 $payment_status = DoctorsCourses::find($doctor_course_id);
    //                 $payment_status->payment_status='Completed';
    //                 $payment_status->push();
    //                 Session::flash('status', ' Payment Success!');
    //                 return view('my_courses', $data);
    //             } else {
    //                 $payment_status = DoctorsCourses::find($doctor_course_id);
    //                 $payment_status->payment_status='In Progress';
    //                 $payment_status->push();
    //                 Session::flash('status', ' Payment Success!');
    //                 return view('my_courses', $data);
    //             }

    //             Session::flash('status', ' Payment Success!');
    //             return view('my_courses', $data);

    //         }
    //     }
        
    // }


    public function question_submit(Request $request)
    {
        
        if ($request->lecture_video_id) {
            if (DoctorAsks::where(['doctor_id'=>Auth::id(),'lecture_video_id'=>$request->lecture_video_id])->exists()){
                $ask_id = DoctorAsks::where(['doctor_id'=>Auth::id(),'lecture_video_id'=>$request->lecture_video_id])->first();
                return redirect('view-answer/'.$ask_id->id);
            } else {
                $question = new DoctorAsks();
                $question->doctor_id = Auth::id();
                $question->doctor_course_id = $request->doctor_course_id;
                $question->lecture_video_id = $request->lecture_video_id;
                $question->save();

                $data_id = $question->id;

                return redirect('view-answer/'.$data_id);
                //return redirect('question-answer/'.$data_id);
            }

        } else {
            Session::flash('message', 'NOT Submited!');
            return back();
        }
    }

    public function question_answer($id)
    {
        if (Auth::id()) {
            $data['doc_info'] = Doctors::where('id', Auth::id())->first();
            $data['doctor_ask_id'] = $id;
            return view('question_answer', $data);
        }
    }

    public function question_submit_final(Request $request)
    {
        
        if ($request->description) {
            $question = new DoctorAskReply();
            $question->doctor_id = Auth::id();
            $question->user_id = 0;
            $question->message_by = 'doctor';
            $question->message = $request->description;
            $question->doctor_ask_id = $request->ask_id;
            $question->is_read = 'No';
            $question->save();

            Session::flash('message', 'Question Submit successfully');
            return back();
        } else {
            Session::flash('message', 'NOT Submited!');
            return back();
        }
    }

    public function view_answer($id)
    {
        if (Auth::id()) {
            $data['doc_info'] = Doctors::where('id', Auth::id())->first();
            $data['answer_info'] = DoctorAskReply::select('*')->where('doctor_ask_id', $id)->get();
            $data['ask_id'] = $id;
            $data['ask_info'] = DoctorAsks::select('*')->where('id', $id)->first();
            return view('view_answer', $data);
        }
    }

    public function question_again(Request $request)
    {
        
        if ($request->description) {
            $question = new DoctorAskReply();
            $question->doctor_id = Auth::id();
            $question->user_id = 0;
            $question->message_by = 'doctor';
            $question->message = $request->description;
            $question->doctor_ask_id = $request->ask_id;
            $question->is_read = 'No';
            $question->save();

            Session::flash('message', 'Question Submit successfully');
            return back();
        } else {
            Session::flash('message', 'NOT Submited!');
            return back();
        }
    }

    public function payment($course_id)
    {

        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['doctor'] = Doctors::where('id', Auth::id())->first();

        $data['course_info'] = DoctorsCourses::where(['id'=>$course_id])->first();
        $data['lecture_sheet'] = $data['course_info']->include_lecture_sheet;
        $data['divisions'] = Divisions::get()->pluck('name', 'id');

        return view('payment',$data);
        
    }

    public function payment_create(Request $request, $doctor_id, $course_id)
    {   
        $table = DoctorsCourses::find($course_id);
        $table->payment_status = "Requested";
        $table->push();

        $payment_serial = DoctorCoursePayment::where('doctor_course_id',$course_id)->count();
        $payment_serial = $payment_serial + 1;

        $table = new DoctorCoursePayment;
        $table->doctor_course_id = $course_id;
        $table->payment_type = $request->payment_type;
        $table->mobile_or_name = $request->mobile_or_name;
        $table->transaction_or_account = $request->transaction_or_account;
        $table->amount = $request->amount;
        $table->payment_serial = $payment_serial;
        $table->save();

        return redirect('payment-details');
    }
}

