<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DoctorsCourses;
use App\OnlineExamLink;
use App\OnlineExam;
use App\OnlineExamDiscipline;
use App\OnlineExamBatchOnlineExam;
use App\Sessions;
use Illuminate\Http\Request;
use App\Exam;
use App\Exam_question;
use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Subjects;
use App\Batches;
use App\Topics;
use Session;
use Auth;
use Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class OnlineExamController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $data['online_exams'] = OnlineExam::get();
        $data['module_name'] = 'Online Exam';
        $data['title'] = 'Online Exam List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.online_exam.list',$data);
                
        //echo $Institutes;
        //echo $title;
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

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');

        $data['institutes'] = Institutes::pluck('name', 'id');

        //$data['exam_comm_codees'] = OnlineLectureAddress::pluck('name', 'id');

        $data['module_name'] = 'Online Exam';
        $data['title'] = 'Online Exam Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.online_exam.create',$data);
        //echo "Topic create";
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'exam_comm_code' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'topic_id' => ['required'],               
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\OnlineExamController@create')->withInput();
        }        

        if (OnlineExam::where(['name'=>$request->name])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Online Exam Name already exists');
            return redirect()->action('Admin\OnlineExamController@create')->withInput();
        }    

        if (OnlineExam::where(['exam_comm_code'=>$request->exam_comm_code])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Online Exam Common Code already exists');
            return redirect()->action('Admin\OnlineExamController@create')->withInput();
        }
        else{

            $online_exam = new OnlineExam();
            $online_exam->name = $request->name;
            $online_exam->exam_comm_code = $request->exam_comm_code;
            $online_exam->institute_id=$request->institute_id;
            $online_exam->course_id=$request->course_id;
            $online_exam->faculty_id=$request->faculty_id;
            // $online_exam->subject_id=$request->subject_id;
            $online_exam->topic_id=$request->topic_id;
            $online_exam->status=$request->status;
            $online_exam->created_by=Auth::id();
            $online_exam->save();

            if (OnlineExamDiscipline::where('online_exam_id', $online_exam->id)->first()) {
                OnlineExamDiscipline::where('online_exam_id', $online_exam->id)->delete();
            }
    
            if($request->subject_id)
            {        
                if (is_array($request->subject_id)) {                    
                    foreach ($request->subject_id as $key => $value) {
                        if($value=='')continue;
                        OnlineExamDiscipline::insert(['online_exam_id' => $online_exam->id, 'subject_id' => $value]);
                    }
                }
            }

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\OnlineExamController@index');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $online_exam=OnlineExam::select('online_exams.*')->find($id);
        return view('admin.online_exam.show',['online_exam'=>$online_exam]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       /* $user=Subjects::find(Auth::id());
        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        $online_exam = OnlineExam::find($id);
        $data['online_exam'] = OnlineExam::find($id);

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');
        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['online_exams'] = OnlineExam::pluck('name', 'id');
        
        $institute = Institutes::where('id',$online_exam->institute_id)->first();
        if($institute)$institute_type = $institute->type;
        else $institute_type = null;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'courses-faculties':'courses-subjects';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::where('institute_id',$online_exam->institute_id)->pluck('name', 'id');
        
        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$online_exam->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$online_exam->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$online_exam->course_id)->pluck('name', 'id');
        }

        $selected_subjects = array();
        if(count($online_exam->disciplines)>0){
            foreach($online_exam->disciplines as $online_exam_discipline)
            {
                $selected_subjects[] = $online_exam_discipline->subject_id;
            }
        }
        
        $data['selected_subjects'] = collect($selected_subjects);

        $data['topics'] = Topics::where('course_id',$online_exam->course_id)
            ->pluck('name', 'id');

        $data['module_name'] = 'Online Exam';
        $data['title'] = 'Online Exam Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.online_exam.edit', $data);
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //echo '<pre>';print_r($request->subject_id);exit;
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'exam_comm_code' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'topic_id' => ['required'],        
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        $online_exam = OnlineExam::find($id);

        if($online_exam->name != $request->name) {

            if (OnlineExam::where(['name'=>$request->name])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Online Exam Name already exists');
                return redirect()->action('Admin\OnlineExamController@edit',[$id])->withInput();
            }

        }

        if($online_exam->exam_comm_code != $request->exam_comm_code) {

            if (OnlineExam::where(['exam_comm_code'=>$request->exam_comm_code])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Online Exam Common Code already exists');
                return redirect()->action('Admin\OnlineExamController@edit',[$id])->withInput();
            }

        }

        $online_exam->name = $request->name;
        $online_exam->exam_comm_code = $request->exam_comm_code;
        $online_exam->institute_id=$request->institute_id;
        $online_exam->course_id=$request->course_id;
        $online_exam->faculty_id=$request->faculty_id;
        // $online_exam->subject_id=$request->subject_id;
        //$online_exam->topic_id=$request->topic_id;
        $online_exam->status=$request->status;
        $online_exam->updated_by=Auth::id();
        $online_exam->push();

        if (OnlineExamDiscipline::where('online_exam_id', $online_exam->id)->first()) {
            OnlineExamDiscipline::where('online_exam_id', $online_exam->id)->delete();
        }

        if($request->subject_id)
        {        
            if (is_array($request->subject_id)) {                    
                foreach ($request->subject_id as $key => $value) {
                    if($value=='')continue;
                    OnlineExamDiscipline::insert(['online_exam_id' => $online_exam->id, 'subject_id' => $value]);
                }
            }
        }

        Session::flash('message', 'Record has been updated successfully');
        return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$user=Subjects::find(Auth::id());
        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        OnlineExam::destroy($id); // 1 way
        if (OnlineExamDiscipline::where('online_exam_id', $id)->first()) {
            OnlineExamDiscipline::where('online_exam_id', $id)->delete();
        }
        if (OnlineExamBatchOnlineExam::where('online_exam_id', $id)->first()) {
            OnlineExamBatchOnlineExam::where('online_exam_id', $id)->delete();
        }
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\OnlineExamController@index');
    }

    public function download_emails($id){

        $online_exam = OnlineExam::find($id);
        $emails = array();

        foreach($online_exam->batches as $batch){
            unset($online_exam_batch_id);
            $lecture_link = OnlineExamLink::where('id',$batch->online_exam_batch_id)->get()[0];
            unset($doctors_courses);
            $doctors_courses = DoctorsCourses::where(['year'=>$lecture_link->year,'session_id'=>$lecture_link->session_id,'institute_id'=>$lecture_link->institute_id,'course_id'=>$lecture_link->course_id,'batch_id'=>$lecture_link->batch_id])->get();
            
            foreach($doctors_courses as $doctor_course){
                $emails[] = $doctor_course->doctor->email;
            }
        }

        $content = implode(',',$emails);
        $file_name = $online_exam->name.'.csv';
        $headers = [
                        'Content-type'        => 'text/csv',
                        'Content-Disposition' => 'attachment; filename='.$file_name,
                ];
            
        return Response::make($content, 200, $headers);
        
    }
}  