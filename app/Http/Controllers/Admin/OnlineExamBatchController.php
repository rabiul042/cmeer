<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\OnlineExam;
use App\OnlineExamBatch;
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
use App\Branch;
use Session;
use Auth;
use Validator;

use Illuminate\Support\Facades\DB;


class OnlineExamBatchController extends Controller
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
        $data['online_exam_batches'] = OnlineExamBatch::get();
        $data['module_name'] = 'Online Exam Batch';
        $data['title'] = 'Online Exam Batch List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.online_exam_batch.list',$data);

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

        $data['online_exams'] = OnlineExam::pluck('name', 'id');

        $data['module_name'] = 'Online Exam Batch';
        $data['title'] = 'Online Exam Batch Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.online_exam_batch.create',$data);
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
            'online_exam_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\OnlineExamBatchController@create')->withInput();
        }

        if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
        {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\OnlineExamBatchController@create')->withInput();

        }

        if (OnlineExamBatch::where(['year'=>$request->year,'session_id'=>$request->session_id,'branch_id'=>$request->branch_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This link already exists for the batch');
            return redirect()->action('Admin\OnlineExamBatchController@create')->withInput();
        }
        else{

            $online_exam_batch = new OnlineExamBatch();
                        
            $online_exam_batch->year = $request->year;
            $online_exam_batch->session_id = $request->session_id;
            $online_exam_batch->branch_id=$request->branch_id;
            $online_exam_batch->institute_id=$request->institute_id;
            $online_exam_batch->course_id=$request->course_id;
            $online_exam_batch->faculty_id=$request->faculty_id;
            $online_exam_batch->subject_id=$request->subject_id;
            $online_exam_batch->batch_id=$request->batch_id;
            $online_exam_batch->status=$request->status;
            $online_exam_batch->created_by=Auth::id();
            $online_exam_batch->save();

            
            $online_exam_ids = $request->online_exam_id;

            if (is_array($online_exam_ids)) {
                foreach ($online_exam_ids as $key => $value) {
                        
                        if($value == '')continue;
                    
                        unset($online_exam_batch_online_exam);
                        $online_exam_batch_online_exam = new OnlineExamBatchOnlineExam();
                        $online_exam_batch_online_exam->online_exam_batch_id = $online_exam_batch->id;
                        $online_exam_batch_online_exam->online_exam_id = $value;
                        //$online_exam_batch_online_exam->status = $request->status;
                        //$online_exam_batch_online_exam->created_by = Auth::id();
                        $online_exam_batch_online_exam->save();
                        
                }
            }

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\OnlineExamBatchController@index');
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
        $online_exam_batch=OnlineExamBatch::select('online_exam_batchs.*')->find($id);
        return view('admin.online_exam_batch.show',['online_exam_batch'=>$online_exam_batch]);
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
        $online_exam_batch = OnlineExamBatch::find($id);
        $data['online_exam_batch'] = OnlineExamBatch::find($id);

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');
        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['online_exams'] = OnlineExam::pluck('name', 'id');

        $data['branches'] = Branch::pluck('name','id');
        $institute_type = Institutes::where('id',$online_exam_batch->institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'courses-faculties-topics-batches-lectures':'courses-subjects-topics-batches-lectures';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::where('institute_id',$online_exam_batch->institute_id)->pluck('name', 'id');

        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$online_exam_batch->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$online_exam_batch->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$online_exam_batch->course_id)->pluck('name', 'id');
        }

        $data['batches'] = Batches::where('institute_id',$online_exam_batch->institute_id)
            ->where('course_id',$online_exam_batch->course_id)
            ->where('branch_id',$online_exam_batch->branch_id)
            ->pluck('name', 'id');
        
        
        $data['online_exams'] = OnlineExam::where(['institute_id'=>$online_exam_batch->institute_id,'course_id'=>$online_exam_batch->course_id])->pluck('name', 'id');
        $selected_videos = array();
        foreach($online_exam_batch->online_exams as $online_exam)
        {
            $selected_videos[] = $online_exam->online_exam_id;
        }        

        $data['selected_videos'] = collect($selected_videos);

        $data['online_exams'] = OnlineExam::pluck('name', 'id');
                
        $data['module_name'] = 'Online Exam Batch';
        $data['title'] = 'Online Exam Batch Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.online_exam_batch.edit', $data);
        
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
            'online_exam_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        $online_exam_batch = OnlineExamBatch::find($id);

        if($online_exam_batch->branch_id != $request->branch_id)
        {
            if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
            {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\OnlineExamBatchController@edit',[$id])->withInput();

            }

        }

        if($online_exam_batch->year != $request->year || $online_exam_batch->session_id != $request->session_id || $online_exam_batch->branch_id != $request->branch_id || $online_exam_batch->institute_id != $request->institute_id || $online_exam_batch->course_id != $request->course_id || $online_exam_batch->batch_id != $request->batch_id) {

            if (OnlineExamBatch::where(['year'=>$request->year,'session_id'=>$request->session_id,'branch_id'=>$request->branch_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Lecture Address already exists for the batch');
                return redirect()->action('Admin\OnlineExamBatchController@edit',[$id])->withInput();
            }

        }

        $online_exam_batch->year = $request->year;
        $online_exam_batch->session_id = $request->session_id;
        $online_exam_batch->branch_id=$request->branch_id;
        $online_exam_batch->institute_id=$request->institute_id;
        $online_exam_batch->course_id=$request->course_id;
        $online_exam_batch->faculty_id=$request->faculty_id;
        $online_exam_batch->subject_id=$request->subject_id;
        $online_exam_batch->batch_id=$request->batch_id;
        $online_exam_batch->status=$request->status;
        $online_exam_batch->updated_by=Auth::id();
        $online_exam_batch->push();


        $online_exam_ids = $request->online_exam_id;

        if(OnlineExamBatchOnlineExam::where('online_exam_batch_id',$online_exam_batch->id)->first())
        {
            OnlineExamBatchOnlineExam::where('online_exam_batch_id',$online_exam_batch->id)->delete();       
        }

        if (is_array($online_exam_ids)) {
            
            foreach ($online_exam_ids as $key => $value) {
                    
                    if($value == '')continue;
                
                    unset($online_exam_batch_online_exam);
                    $online_exam_batch_online_exam = new OnlineExamBatchOnlineExam();
                    $online_exam_batch_online_exam->online_exam_batch_id = $online_exam_batch->id;
                    $online_exam_batch_online_exam->online_exam_id = $value;
                    //$online_exam_batch_online_exam->status = $request->status;
                    //$online_exam_batch_online_exam->created_by = Auth::id();
                    $online_exam_batch_online_exam->save();
                    
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
        OnlineExamBatch::destroy($id); // 1 way
        OnlineExamBatchOnlineExam::where('online_exam_batch_id',$id)->delete(); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\OnlineExamBatchController@index');
    }
}