<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DoctorsCourses;
use App\LectureVideoLink;
use App\LectureVideo;
use App\LectureVideoDiscipline;
use App\LectureVideoBatchLectureVideo;
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


class LectureVideoController extends Controller
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
        $data['lecture_videos'] = LectureVideo::get();
        $data['module_name'] = 'Lecture Video';
        $data['title'] = 'Lecture Video List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.lecture_video.list',$data);
                
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

        //$data['lecture_addresses'] = OnlineLectureAddress::pluck('name', 'id');

        $data['module_name'] = 'Lecture Video';
        $data['title'] = 'Lecture Video Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.lecture_video.create',$data);
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
            'lecture_address' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'topic_id' => ['required'],
    
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\LectureVideoController@create')->withInput();
        }        

        if (LectureVideo::where(['name'=>$request->name])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Lecture Address Name already exists');
            return redirect()->action('Admin\LectureVideoController@create')->withInput();
        }    

        if (LectureVideo::where(['lecture_address'=>$request->lecture_address])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Lecture Address already exists');
            return redirect()->action('Admin\LectureVideoController@create')->withInput();
        }
        else{

            $lecture_video = new LectureVideo();
            $lecture_video->name = $request->name;
            $lecture_video->lecture_address = $request->lecture_address;
            $lecture_video->password = $request->password;
            if($request->hasFile('pdf')){
                $file = $request->file('pdf');
                $extension = $file->getClientOriginalExtension();
                $filename = date("ymd").'_'.time().'.'.$extension;
                $file->move('pdf/',$filename);
                $lecture_video->pdf_file = $filename;
            }
            else {
                $lecture_video->pdf_file = '';
            }
                        
            //$lecture_video->year = $request->year;
            //$lecture_video->session_id = $request->session_id;
            $lecture_video->institute_id=$request->institute_id;
            $lecture_video->course_id=$request->course_id;
            $lecture_video->faculty_id=$request->faculty_id;
            // $lecture_video->subject_id=$request->subject_id;
            $lecture_video->topic_id=$request->topic_id;
            $lecture_video->status=$request->status;
            $lecture_video->created_by=Auth::id();
            $lecture_video->save();

            if (LectureVideoDiscipline::where('lecture_video_id', $lecture_video->id)->first()) {
                LectureVideoDiscipline::where('lecture_video_id', $lecture_video->id)->delete();
            }
    
            if($request->subject_id)
            {        
                if (is_array($request->subject_id)) {                    
                    foreach ($request->subject_id as $key => $value) {
                        if($value=='')continue;
                        LectureVideoDiscipline::insert(['lecture_video_id' => $lecture_video->id, 'subject_id' => $value]);
                    }
                }
            }

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\LectureVideoController@index');
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
        $lecture_video=LectureVideo::select('lecture_videos.*')->find($id);
        return view('admin.lecture_video.show',['lecture_video'=>$lecture_video]);
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
        $lecture_video = LectureVideo::find($id);
        $data['lecture_video'] = LectureVideo::find($id);

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');
        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['lecture_videos'] = LectureVideo::pluck('name', 'id');
        
        $institute = Institutes::where('id',$lecture_video->institute_id)->first();
        if($institute)$institute_type = $institute->type;
        else $institute_type = null;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'courses-faculties':'courses-subjects';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::where('institute_id',$lecture_video->institute_id)->pluck('name', 'id');
        
        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$lecture_video->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$lecture_video->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$lecture_video->course_id)->pluck('name', 'id');
        }

        $selected_subjects = array();
        if(count($lecture_video->disciplines)>0){
            foreach($lecture_video->disciplines as $lecture_video_discipline)
            {
                $selected_subjects[] = $lecture_video_discipline->subject_id;
            }
        }
        
        $data['selected_subjects'] = collect($selected_subjects);

        $data['topics'] = Topics::where('course_id',$lecture_video->course_id)
            ->pluck('name', 'id');

        $data['module_name'] = 'Lecture Video';
        $data['title'] = 'Lecture Video Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.lecture_video.edit', $data);
        
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
            'lecture_address' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'topic_id' => ['required'],
        
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        $lecture_video = LectureVideo::find($id);

        if($lecture_video->name != $request->name) {

            if (LectureVideo::where(['name'=>$request->name])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Lecture Address Name already exists');
                return redirect()->action('Admin\LectureVideoController@edit',[$id])->withInput();
            }

        }

        if($lecture_video->lecture_address != $request->lecture_address) {

            if (LectureVideo::where(['lecture_address'=>$request->lecture_address])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Lecture Address already exists');
                return redirect()->action('Admin\LectureVideoController@edit',[$id])->withInput();
            }

        }

        $lecture_video->name = $request->name;
        $lecture_video->lecture_address = $request->lecture_address;
        $lecture_video->password = $request->password;
        if($request->hasFile('pdf')){
            $file = $request->file('pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = date("ymd").'_'.time().'.'.$extension;
            $file->move('pdf/',$filename);
            $lecture_video->pdf_file = $filename;
        }
        //$lecture_video->year = $request->year;
        //$lecture_video->session_id = $request->session_id;
        $lecture_video->institute_id=$request->institute_id;
        $lecture_video->course_id=$request->course_id;
        $lecture_video->faculty_id=$request->faculty_id;
        // $lecture_video->subject_id=$request->subject_id;
        $lecture_video->topic_id=$request->topic_id;
        $lecture_video->status=$request->status;
        $lecture_video->updated_by=Auth::id();
        $lecture_video->push();

        if (LectureVideoDiscipline::where('lecture_video_id', $lecture_video->id)->first()) {
            LectureVideoDiscipline::where('lecture_video_id', $lecture_video->id)->delete();
        }

        if($request->subject_id)
        {        
            if (is_array($request->subject_id)) {                    
                foreach ($request->subject_id as $key => $value) {
                    if($value=='')continue;
                    LectureVideoDiscipline::insert(['lecture_video_id' => $lecture_video->id, 'subject_id' => $value]);
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
        LectureVideo::destroy($id); // 1 way
        if (LectureVideoDiscipline::where('lecture_video_id', $id)->first()) {
            LectureVideoDiscipline::where('lecture_video_id', $id)->delete();
        }
        if (LectureVideoBatchLectureVideo::where('lecture_video_id', $id)->first()) {
            LectureVideoBatchLectureVideo::where('lecture_video_id', $id)->delete();
        }
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\LectureVideoController@index');
    }

    public function download_emails($id){

        $lecture_video = LectureVideo::find($id);
        $emails = array();

        foreach($lecture_video->batches as $batch){
            unset($lecture_video_batch_id);
            $lecture_link = LectureVideoLink::where('id',$batch->lecture_video_batch_id)->get()[0];
            unset($doctors_courses);
            $doctors_courses = DoctorsCourses::where(['year'=>$lecture_link->year,'session_id'=>$lecture_link->session_id,'institute_id'=>$lecture_link->institute_id,'course_id'=>$lecture_link->course_id,'batch_id'=>$lecture_link->batch_id])->get();
            
            foreach($doctors_courses as $doctor_course){
                $emails[] = $doctor_course->doctor->email;
            }
        }

        $content = implode(',',$emails);
        $file_name = $lecture_video->name.'.csv';
        $headers = [
                        'Content-type'        => 'text/csv',
                        'Content-Disposition' => 'attachment; filename='.$file_name,
                ];
            
        return Response::make($content, 200, $headers);
        
    }
}  