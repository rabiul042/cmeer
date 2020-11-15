<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exam;
use App\Exam_question;
use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Subjects;
use App\Batches;
use App\Branch;
use App\Sessions;
use App\DoctorsCourses;
use App\DisciplineFee;
use Session;
use Auth;
use Validator;

use Illuminate\Support\Facades\DB;


class BatchController extends Controller
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
        $batches = Batches::get();
        $title = 'Batch List';
        return view('admin.batch.list',['batches'=>$batches, 'title'=>$title]);
                
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
        
        $data['institute'] = Institutes::get()->pluck('name', 'id');
        $data['branches'] = Branch::pluck('name', 'id');

        $data['title'] = 'Batch Create';

        return view('admin.batch.create',$data);
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
            'batch_code' => ['required'],
            'start_index' => ['required'],
            'end_index' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'branch_id' => ['required'],
            //'fee_type' => ['required'],
            'status'=> ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter valid data!!!');
            return redirect()->action('Admin\BatchController@create')->withInput();
        }

        if (Batches::where('name',$request->name)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Batch Name already exists');
            return redirect()->action('Admin\BatchController@create')->withInput();
        }
        if (Batches::where(['batch_code'=>$request->batch_code,'course_id'=>$request->course_id])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Batch Code already exists');
            return redirect()->action('Admin\BatchController@create')->withInput();
        }
        else{

            $batch = new Batches();
            $batch->name=$request->name;
            $batch->batch_code=$request->batch_code;
            $batch->start_index=$request->start_index;
            $batch->end_index=$request->end_index;
            $batch->institute_id=$request->institute_id;
            $batch->course_id=$request->course_id;
            $batch->subject_id=$request->subject_id;
            $batch->branch_id=$request->branch_id;

            $batch->fee_type="Batch";

            $batch->admission_fee=$request->admission_fee;
            $batch->payment_times=$request->payment_times;
            $batch->minimum_payment=$request->minimum_payment;

            $batch->details=$request->details;

            $batch->status=$request->status;
            $batch->created_by=Auth::id();
            
            $batch->save();

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\BatchController@index');
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
        $user=Subjects::select('users.*')->find($id);
        return view('admin.subjects.show',['user'=>$user]);
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
        $batch = Batches::find($id);
        $data['batch'] = Batches::find($id);
        $data['branches'] = Branch::pluck('name', 'id');
        $data['institute'] = Institutes::pluck('name', 'id');
        $data['course'] = Courses::where('institute_id', $batch->institute_id)->pluck('name', 'id');
        $data['faculty'] = Faculty::where('id', $batch->faculty_id)->pluck('name', 'id');
        $data['subjects'] = Subjects::where('course_id', $batch->course_id)->pluck('name', 'id');
        $data['title'] = 'Batch Edit';
        return view('admin.batch.edit', $data);
        
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
            'name' => ['required'],
            'batch_code' => ['required'],
            'start_index' => ['required'],
            'end_index' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'branch_id' => ['required'],
            //'fee_type' => ['required'],
            'status' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return redirect()->action('Admin\BatchController@edit', [$id])->withInput();
        }
        
        $batch = Batches::find($id);

        if($batch->name != $request->name) {

            if (Batches::where('name', $request->name)->exists()) {
                Session::flash('class', 'alert-danger');
                session()->flash('message', 'This Batch Name already exists');
                return redirect()->action('Admin\BatchController@edit', [$id])->withInput();
            }

        }

        if($batch->batch_code != $request->batch_code) {

            if (Batches::where(['batch_code'=>$request->batch_code,'course_id'=>$request->course_id])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch Code already exists');
                return redirect()->action('Admin\BatchController@edit',[$id])->withInput();
            }

        }

        $batch->name=$request->name;
        $batch->batch_code=$request->batch_code;
        $batch->start_index=$request->start_index;
        $batch->end_index=$request->end_index;
        $batch->institute_id=$request->institute_id;
        $batch->course_id=$request->course_id;
        $batch->subject_id=$request->subject_id;
        $batch->branch_id=$request->branch_id;

        $batch->fee_type="Batch";

        $batch->admission_fee=$request->admission_fee;
        $batch->payment_times=$request->payment_times;
        $batch->minimum_payment=$request->minimum_payment;

        $batch->details=$request->details;

        $batch->status=$request->status;
        $batch->updated_by=Auth::id();
        
        $batch->push();

        

        Session::flash('message', 'Record has been updated successfully');
        return back();
    }

    
    public function print_batch_doctor_address()
    {  
        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');

        $data['institutes'] = Institutes::pluck('name', 'id');
        $data['branches'] = Branch::pluck('name','id');

        $data['module_name'] = 'Batch Doctors Address';
        $data['title'] = 'Batch Doctors Address Print';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.batch.batch_doctor_address',$data);
        
    }

    public function print_batch_doctors_addresses(Request $request)
    {   
        
        $doctors_courses_unformated = DoctorsCourses::where(['year'=>$request->year,'session_id'=>$request->session_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->get();
        $doctors_courses = array();
        $j=1;$i=1;
        foreach($doctors_courses_unformated as $key=>$doctor_course)
        {
            if(isset($doctor_course->doctor->present_address) && $doctor_course->doctor->present_address != null )
            {
                //echo '<pre>';print_r($doctor_course);
                if($j==3)
                {
                    $i++;
                    $j=1;
                }
                $doctors_courses[$i][$j++] = $doctor_course;
                
            }
            
        }
        $data['doctors_courses'] = $doctors_courses;
        //echo '<pre>';print_r($doctors_courses);exit;
        return view('admin.batch.batch_doctors_addresses_print',$data);
        
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
        Batches::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\BatchController@index');
    }
}