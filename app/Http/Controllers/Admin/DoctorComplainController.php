<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Doctors;
use App\DoctorAsk;
use App\DoctorAsks;
use App\DoctorComplain;
use App\DoctorComplainReply;
use App\Sessions;
use Illuminate\Http\Request;
use App\Exam;
use App\Exam_question;
use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Subjects;
use App\Batches;
use App\Branch;
use App\User;
use Session;
use Auth;
use Validator;

use Illuminate\Support\Facades\DB;


class DoctorComplainController extends Controller
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
        $data['doctor_complain_replies'] = DoctorComplain::get();
        $data['module_name'] = 'Doctor Complain';
        $data['title'] = 'Doctor Complain List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.doctor_complain.list',$data);

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
        $data['branches'] = Branch::pluck('name','id');

        $data['doctor_complains'] = DoctorAsk::pluck('name', 'id');

        $data['module_name'] = 'Doctor Complain';
        $data['title'] = 'Doctor Complain Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.doctor_complain.create',$data);
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
            'year' => ['required'],
            'session_id' => ['required'],
            'branch_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'batch_id' => ['required'],
            'lecture_video_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\DoctorComplainController@create')->withInput();
        }

        if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
        {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\DoctorComplainController@create')->withInput();

        }

        if (DoctorComplain::where(['year'=>$request->year,'session_id'=>$request->session_id,'branch_id'=>$request->branch_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This link already exists for the batch');
            return redirect()->action('Admin\DoctorComplainController@create')->withInput();
        }
        else{

            $doctor_complain_reply = new DoctorComplain();
                        
            $doctor_complain_reply->year = $request->year;
            $doctor_complain_reply->session_id = $request->session_id;
            $doctor_complain_reply->branch_id=$request->branch_id;
            $doctor_complain_reply->institute_id=$request->institute_id;
            $doctor_complain_reply->course_id=$request->course_id;
            $doctor_complain_reply->faculty_id=$request->faculty_id;
            $doctor_complain_reply->subject_id=$request->subject_id;
            $doctor_complain_reply->batch_id=$request->batch_id;
            $doctor_complain_reply->status=$request->status;
            $doctor_complain_reply->created_by=Auth::id();
            $doctor_complain_reply->save();

            
            $lecture_video_ids = $request->lecture_video_id;

            if (is_array($lecture_video_ids)) {
                foreach ($lecture_video_ids as $key => $value) {
                        
                        if($value == '')continue;
                    
                        unset($lecture_video_batch_lecture_video);
                        $lecture_video_batch_lecture_video = new DoctorAskBatchDoctorAsk();
                        $lecture_video_batch_lecture_video->lecture_video_batch_id = $doctor_complain_reply->id;
                        $lecture_video_batch_lecture_video->lecture_video_id = $value;
                        //$lecture_video_batch_lecture_video->status = $request->status;
                        //$lecture_video_batch_lecture_video->created_by = Auth::id();
                        $lecture_video_batch_lecture_video->save();
                        
                }
            }

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\DoctorComplainController@index');
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
        //$doctor_complain_reply=DoctorComplain::select('doctor_complain_reply.*')->find($id);
        //return view('admin.doctor_complain.show',['doctor_complain_reply'=>$doctor_complain_reply]);
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
        $doctor_complain_reply = DoctorComplain::find($id);
        $data['doctor_complain_reply'] = DoctorComplain::find($id);

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');
        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['doctor_complains'] = DoctorAsk::pluck('name', 'id');

        $data['branches'] = Branch::pluck('name','id');
        $institute_type = Institutes::where('id',$doctor_complain_reply->institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'courses-faculties-topics-batches-lectures':'courses-subjects-topics-batches-lectures';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::where('institute_id',$doctor_complain_reply->institute_id)->pluck('name', 'id');

        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$doctor_complain_reply->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$doctor_complain_reply->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$doctor_complain_reply->course_id)->pluck('name', 'id');
        }

        $data['batches'] = Batches::where('institute_id',$doctor_complain_reply->institute_id)
            ->where('course_id',$doctor_complain_reply->course_id)
            ->where('branch_id',$doctor_complain_reply->branch_id)
            ->pluck('name', 'id');
        
        
        $data['lecture_videos'] = DoctorAsk::where(['institute_id'=>$doctor_complain_reply->institute_id,'course_id'=>$doctor_complain_reply->course_id])->pluck('name', 'id');
        $selected_videos = array();
        foreach($doctor_complain_reply->lecture_videos as $lecture_video)
        {
            $selected_videos[] = $lecture_video->lecture_video_id;
        }        

        $data['selected_videos'] = collect($selected_videos);
                
        $data['module_name'] = 'Doctor Complain';
        $data['title'] = 'Doctor Complain Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.doctor_complain.edit', $data);
        
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
        $validator = Validator::make($request->all(), [
            'year' => ['required'],
            'session_id' => ['required'],
            'branch_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'batch_id' => ['required'],
            'lecture_video_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        $doctor_complain_reply = DoctorComplain::find($id);

        if($doctor_complain_reply->branch_id != $request->branch_id)
        {
            if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
            {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\DoctorComplainController@edit',[$id])->withInput();

            }

        }

        if($doctor_complain_reply->year != $request->year || $doctor_complain_reply->session_id != $request->session_id || $doctor_complain_reply->branch_id != $request->branch_id || $doctor_complain_reply->institute_id != $request->institute_id || $doctor_complain_reply->course_id != $request->course_id || $doctor_complain_reply->batch_id != $request->batch_id) {

            if (DoctorComplain::where(['year'=>$request->year,'session_id'=>$request->session_id,'branch_id'=>$request->branch_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Lecture Address already exists for the batch');
                return redirect()->action('Admin\DoctorComplainController@edit',[$id])->withInput();
            }

        }

        $doctor_complain_reply->year = $request->year;
        $doctor_complain_reply->session_id = $request->session_id;
        $doctor_complain_reply->branch_id=$request->branch_id;
        $doctor_complain_reply->institute_id=$request->institute_id;
        $doctor_complain_reply->course_id=$request->course_id;
        $doctor_complain_reply->faculty_id=$request->faculty_id;
        $doctor_complain_reply->subject_id=$request->subject_id;
        $doctor_complain_reply->batch_id=$request->batch_id;
        $doctor_complain_reply->status=$request->status;
        $doctor_complain_reply->updated_by=Auth::id();
        $doctor_complain_reply->push();


        $lecture_video_ids = $request->lecture_video_id;

        if (is_array($lecture_video_ids)) {

            if(DoctorAskBatchDoctorAsk::where('lecture_video_batch_id',$doctor_complain_reply->id)->first())
            {
                DoctorAskBatchDoctorAsk::where('lecture_video_batch_id',$doctor_complain_reply->id)->delete();       
            }
            foreach ($lecture_video_ids as $key => $value) {
                    
                    if($value == '')continue;
                
                    unset($lecture_video_batch_lecture_video);
                    $lecture_video_batch_lecture_video = new DoctorAskBatchDoctorAsk();
                    $lecture_video_batch_lecture_video->lecture_video_batch_id = $doctor_complain_reply->id;
                    $lecture_video_batch_lecture_video->lecture_video_id = $value;
                    //$lecture_video_batch_lecture_video->status = $request->status;
                    //$lecture_video_batch_lecture_video->created_by = Auth::id();
                    $lecture_video_batch_lecture_video->save();
                    
            }
        }
        Session::flash('message', 'Record has been updated successfully');
        return back();
    }

    public function doctor_complain_list()
    {
        $data['module_name'] = 'Doctors Complains';
        $data['title'] = 'Doctors Complains List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';
        
        $doctor_complain_reply_list = DoctorComplainReply::where(['is_read'=>'No','user_id'=>"0"])->orderBy('created_at','desc')->get();
        $doctor_complain_reply_list1 = DoctorComplainReply::where(['is_read'=>'Yes'])->orderBy('created_at','desc')->get();
        
        $collections = $doctor_complain_reply_list->merge($doctor_complain_reply_list1)->unique('doctor_complain_id')->values()->all();
        $array_id = array();
        foreach($collections as $collection)
        {
            $array_id[] = $collection->doctor_complain_id;
        }
        
        $data['doctor_complain_list'] = DoctorComplain::whereIn('id',$array_id)->orderByRaw("FIELD(id, ".implode(',',$array_id).")")->get();
        
        return view('admin.doctor_complain.doctor_complain_list', $data);
    }

    public function view_complain($id)
    {        

        if(DoctorComplainReply::where('doctor_complain_id',$id)->count()>0){

            $data['module_name'] = 'Doctor Complain';
            $data['title'] = 'Doctor Complain';
            $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
            $data['submit_value'] = 'Submit';

            $doctor_complain_reply = DoctorComplainReply::where(['doctor_complain_id'=>$id,'user_id'=>"0"])->update(['is_read'=>'Yes']);       
        
            $data['doctor_complain_reply'] = $doctor_complain_reply;        
            $data['user'] = User::find(Auth::id());
            $data['doctor_complain_replies'] = DoctorComplainReply::where('doctor_complain_id',$id)->get();
            return view('admin.doctor_complain.view_complain', $data);
        }
        else
        {
            Session::flash('class', 'alert-danger');
            Session::flash('message', 'The doctor did not complained');
            return redirect()->action('Admin\DoctorComplainController@doctor_complain_list');        
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply_complain(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required'],
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return redirect()->action('Admin\DoctorComplainController@view_complain',[$request->doctor_complain_id])->withInput();
        }

        $doctor_complain_reply = new DoctorComplainReply();
        
        $doctor_complain_reply->doctor_id = $request->doctor_id;
        $doctor_complain_reply->user_id = Auth::id();
        $doctor_complain_reply->message_by = 'admin';
        $doctor_complain_reply->message = $request->message;
        $doctor_complain_reply->doctor_complain_id = $request->doctor_complain_id;
        $doctor_complain_reply->is_read = 'No';

        $doctor_complain_reply->save();

        Session::flash('message', 'Record has been added successfully');
        return redirect()->action('Admin\DoctorComplainController@view_complain',[$request->doctor_complain_id]);
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
        DoctorComplain::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\DoctorComplainController@index');
    }
}