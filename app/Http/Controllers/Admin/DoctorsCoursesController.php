<?php

namespace App\Http\Controllers\Admin;

use App\Coming_by;
use App\ComingBy;
use App\Http\Controllers\Controller;

use App\MedicalColleges;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Subjects;
use App\Batches;
use App\BatchDisciplineFee;
use App\Branch;
use App\Doctors;
use App\Sessions;
use App\Service_packages;
use App\ServicePackages;
use App\DoctorsCourses;
use Session;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class DoctorsCoursesController extends Controller
{
    //

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Auth::loginUsingId(1);
        //$this->middleware('auth');
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

        $title = 'HTNCR Admin : Doctors Courses List';
        $batches = Batches::get()->pluck('name', 'id');
        $sessions = Sessions::get()->pluck('name', 'id');
        $years = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $years[$year] = $year;
        }
        return view('admin.doctors_courses.list',['title'=>$title,'sessions'=>$sessions,'batches'=>$batches,'years'=>$years]);
    }

    public function doctors_courses_list(Request $request)
    {

        $year = $request->year;
        $session_id = $request->session_id;
        $batch_id = $request->batch_id;

        $doctors_courses_list = DB::table('doctors_courses as d1')
            ->leftjoin('doctors as d2', 'd1.doctor_id', '=','d2.id')
            ->leftjoin('institutes as d3', 'd1.institute_id', '=','d3.id')
            ->leftjoin('courses as d4', 'd1.course_id', '=','d4.id')
            ->leftjoin('faculties as d5', 'd1.faculty_id', '=','d5.id')
            ->leftjoin('subjects as d6', 'd1.subject_id', '=','d6.id')
            ->leftjoin('batches as d7', 'd1.batch_id', '=','d7.id')
            ->leftjoin('sessions as d8', 'd1.session_id', '=','d8.id')
            ->leftjoin('service_packages as d9', 'd1.service_package_id', '=','d9.id')
            ->leftjoin('branches as d10', 'd1.branch_id', '=','d10.id')
            ->leftjoin('doctor_course_payment as d11', 'd1.id', '=','d11.doctor_course_id');

        if($year){
            $doctors_courses_list = $doctors_courses_list->where('year', '=', $year);
        }
        if($session_id){
            $doctors_courses_list = $doctors_courses_list->where('session_id', '=', $session_id);
        }
        if($batch_id){
            $doctors_courses_list = $doctors_courses_list->where('batch_id', '=', $batch_id);
        }

        $doctors_courses_list = $doctors_courses_list->where('is_trash', '=', 0);

        $doctors_courses_list = $doctors_courses_list->select('d1.*','d2.name as doctor_name', 'd2.mobile_number as mobile_number', 'd2.main_password as main_password','d2.bmdc_no as bmdc_no','d3.name as institute_name','d4.name as course_name','d5.name as faculty_name','d6.name as subject_name','d7.name as batche_name','d8.name as session_name','d9.name as service_package_name','d10.name as branch_name', 'd11.id as payment_id', 'd11.doctor_course_id as course_id', 'd11.created_at as created_at', 'd11.amount as amount', 'd11.payment_type as payment_by', 'd11.mobile_or_name as mobile_or_name', 'd11.transaction_or_account as transaction_or_account', 'd11.status as payment_status');

        return Datatables::of($doctors_courses_list)
            ->addColumn('action', function ($doctors_courses_list) {
                return view('admin.doctors_courses.ajax_list',(['doctors_courses_list'=>$doctors_courses_list]));
            })

            ->addColumn('admission_time', function ($doctors_courses_list) {

                return date('d M Y h:m a',strtotime($doctors_courses_list->created_at));
                
            })

            ->make(true);
    }

    public function html()
    {
        return $this->builder()
            ->columns([
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => ['csv', 'excel', 'pdf', 'print', 'reset', 'reload'],
            ]);
    }

    public function doctors_courses_trash()
    {
        /*  if(!$user->hasRole('Admin')){
              return abort(404);
          }*/

        $title = 'HTNCR Admin : Doctors Courses List';
        $batches = Batches::get()->pluck('name', 'id');
        $sessions = DB::table('sessions')->join('course_session','course_session.session_id','=','sessions.id')->pluck(DB::raw('CONCAT(name, " (", duration,")") AS name'), 'sessions.id');

        $years = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $years[$year] = $year;
        }
        return view('admin.doctors_courses.trash_list',['title'=>$title,'sessions'=>$sessions,'batches'=>$batches,'years'=>$years]);
    }


    public function doctors_courses_trash_list(Request $request)
    {

        $year = $request->year;
        $session_id = $request->session_id;
        $batch_id = $request->batch_id;

        $doctors_courses_list = DB::table('doctors_courses as d1')
            ->leftjoin('doctors as d2', 'd1.doctor_id', '=','d2.id')
            ->leftjoin('institutes as d3', 'd1.institute_id', '=','d3.id')
            ->leftjoin('courses as d4', 'd1.course_id', '=','d4.id')
            ->leftjoin('faculties as d5', 'd1.faculty_id', '=','d5.id')
            ->leftjoin('subjects as d6', 'd1.subject_id', '=','d6.id')
            ->leftjoin('batches as d7', 'd1.batch_id', '=','d7.id')
            ->leftjoin('sessions as d8', 'd1.session_id', '=','d8.id')
            ->leftjoin('service_packages as d9', 'd1.service_package_id', '=','d9.id')
            ->leftjoin('branches as d10', 'd1.branch_id', '=','d10.id');

        if($year){
            $doctors_courses_list = $doctors_courses_list->where('year', '=', $year);
        }
        if($session_id){
            $doctors_courses_list = $doctors_courses_list->where('session_id', '=', $session_id);
        }
        if($batch_id){
            $doctors_courses_list = $doctors_courses_list->where('batch_id', '=', $batch_id);
        }

        $doctors_courses_list = $doctors_courses_list->where('is_trash', '=', 1);


        $doctors_courses_list = $doctors_courses_list->select('d1.*','d2.name as doctor_name','d2.main_password as main_password','d2.bmdc_no as bmdc_no','d3.name as institute_name','d4.name as course_name','d5.name as faculty_name','d6.name as subject_name','d7.name as batche_name','d8.name as session_name','d9.name as service_package_name','d10.name as branch_name');

        return Datatables::of($doctors_courses_list)
            ->addColumn('action', function ($doctors_courses_list) {
                return view('admin.doctors_courses.ajax_list_trash',(['doctors_courses_list'=>$doctors_courses_list]));
            })

            ->addColumn('admission_time', function ($doctors_courses_list) {
                return date('d M Y h:m a',strtotime($doctors_courses_list->created_at));
            })

            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user=DoctorsCourses::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }
        
        $data['title'] = 'HTNCR Admin : Doctor Courses Create';
        $data['doctors'] = Doctors::select(DB::raw("CONCAT(name,' - ',bmdc_no) AS full_name"),'id')->orderBy('id', 'DESC')->pluck('full_name', 'id');
        $data['branches'] = Branch::pluck('name', 'id');
        $data['institutes'] = Institutes::get()->pluck('name', 'id');

        //$data['courses'] = Courses::get()->pluck('name', 'id');
        //$data['faculties'] = Faculty::get()->pluck('name', 'id');
        //$data['subjects'] = Subjects::get()->pluck('name', 'id');
        //$data['batches'] = Batches::get()->pluck('name', 'id');
        $data['sessions'] = Sessions::get()->pluck('name', 'id');
        $data['service_packages'] = ServicePackages::get()->pluck('name', 'id');
        $data['coming_bys'] = ComingBy::get()->pluck('name', 'id');

        return view('admin.doctors_courses.create',$data);
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
            'doctor_id' => ['required'],
            /*'service_package_id' => ['required'],*/
            //'coming_by_id' => ['required'],
            'year' => ['required'],
            'session_id' => ['required'],
            'branch_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'batch_id' => ['required'],
            'reg_no_first_part' => ['required'],
            'reg_no_last_part' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\DoctorsCoursesController@create')->withInput();
        }

        $start_index = Batches::where('id',$request->batch_id)->pluck('start_index');
        $end_index = Batches::where('id',$request->batch_id)->pluck('end_index');

        $doctor_course = new DoctorsCourses();
        $doctor_course->doctor_id = $request->doctor_id;
        $doctor_course->refer_by = $request->refer_by;
        $doctor_course->coming_by_id = $request->coming_by_id;
        $doctor_course->year = $request->year;
        $doctor_course->session_id = $request->session_id;
        $doctor_course->branch_id = $request->branch_id;
        $doctor_course->institute_id = $request->institute_id;
        $doctor_course->course_id = $request->course_id;
        $doctor_course->faculty_id = $request->faculty_id;
        $doctor_course->subject_id = $request->subject_id;
        $doctor_course->batch_id = $request->batch_id;
        //$doctor_course->course_price = Batches::where(['id'=>$request->batch_id])->value('admission_fee');

        if(Batches::where(['id'=>$request->batch_id])->value('fee_type') == "Batch")
        {
            $doctor_course->course_price = Batches::where(['id'=>$request->batch_id])->value('admission_fee');
        }
        else if(Batches::where(['id'=>$request->batch_id])->value('fee_type') == "Discipline")
        {
            $doctor_course->course_price = BatchDisciplineFee::where(['batch_id'=>$request->batch_id,'subject_id'=>$request->subject_id])->value('admission_fee');
        }
        if(isset($doctor_course)==false)$doctor_course->course_price=0;

        $doctor_course->payment_status = "No Payment";


        $doctor_course->reg_no = $request->reg_no_first_part.$request->reg_no_last_part;
        $doctor_course->reg_no_first_part = $request->reg_no_first_part;
        $doctor_course->reg_no_last_part = $request->reg_no_last_part;

        if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
        {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\DoctorsCoursesController@create')->withInput();

        }
        
        if (DoctorsCourses::where(['year'=>$request->year,'session_id'=>$request->session_id,'course_id'=>$request->course_id,'reg_no'=>$request->reg_no_first_part.$request->reg_no_last_part])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Registration already exists');
            return redirect()->action('Admin\DoctorsCoursesController@create')->withInput();
        }

        if ($request->reg_no_last_part < $start_index[0] ||  $request->reg_no_last_part > $end_index[0]){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Registration No is not in batch range');
            return redirect()->action('Admin\DoctorsCoursesController@create')->withInput();
        }
        $doctor_course->status = $request->status;
        $doctor_course->created_by = Auth::id();

        $doctor_course->save();
        
        DoctorsCourses::where(['id'=>$doctor_course->id])->update(['created_attt'=>$doctor_course->created_at]);

        Session::flash('message', 'Record has been added successfully');

        //return back();

        return redirect()->action('Admin\DoctorsCoursesController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor_course = DoctorsCourses::with('batch','session')->find($id);
        $data['doctor_course'] = $doctor_course;
        $data['user'] = Doctors::with('medicalcolleges','educations')->find($doctor_course->doctor_id);
        return view('admin.doctors_courses.show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }
        
        $doctor_course = DoctorsCourses::find($id);

        //echo "<pre>";print_r($doctor_course);exit;

        $data['title'] = 'HTNCR Admin : Doctors Courses Edit';
        $data['doctor'] = Doctors::where('id',$doctor_course->doctor_id)->first();
        $data['doctor_course'] = $doctor_course;
        $data['sessions'] = Sessions::get()->pluck('name', 'id');
        $data['service_packages'] = ServicePackages::get()->pluck('name', 'id');
        $data['coming_bys'] = ComingBy::get()->pluck('name', 'id');
        $data['branches'] = Branch::pluck('name', 'id');
        $data['institutes'] = Institutes::get()->pluck('name', 'id');

        $institute_type = Institutes::where('id',$doctor_course->institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'branches-courses-faculties-batches':'branches-courses-subjects-batches';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::get()->where('institute_id',$doctor_course->institute_id)->pluck('name', 'id');

        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$doctor_course->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$doctor_course->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$doctor_course->course_id)->pluck('name', 'id');
        }

        $data['batches'] = Batches::get()->where('institute_id',$doctor_course->institute_id)
            ->where('course_id',$doctor_course->course_id)
            ->where('branch_id',$doctor_course->branch_id)
            ->pluck('name', 'id');
        
        $start_index = Batches::where('id',$doctor_course->batch_id)->value('start_index');
        $end_index = Batches::where('id',$doctor_course->batch_id)->value('end_index');
        $data['range'] = 'Batch Range : ( '.$start_index.' - '.$end_index.' ) ';
        /*echo '<pre>';
        print_r($data);exit;*/

        return view('admin.doctors_courses.edit', $data);
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
            'doctor_id' => ['required'],
            /*'service_package_id' => ['required'],*/
            //'coming_by_id' => ['required'],
            'year' => ['required'],
            'session_id' => ['required'],
            'branch_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'batch_id' => ['required'],
            'reg_no_first_part' => ['required'],
            'reg_no_last_part' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\DoctorsCoursesController@edit',[$id])->withInput();
        }

        $start_index = Batches::where('id',$request->batch_id)->pluck('start_index');
        $end_index = Batches::where('id',$request->batch_id)->pluck('end_index');

        $doctor_course = DoctorsCourses::find($id);

        if($doctor_course->branch_id != $request->branch_id)
        {
            if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
            {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\DoctorsCoursesController@edit',[$id])->withInput();

            }

        }

        if($doctor_course->reg_no != $request->reg_no_first_part.$request->reg_no_last_part){
            if (DoctorsCourses::where('reg_no',$request->reg_no_first_part.$request->reg_no_last_part)->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Registration already exists');
                return redirect()->action('Admin\DoctorsCoursesController@edit',[$id])->withInput();
            }

            if ($request->reg_no_last_part < $start_index[0] ||  $request->reg_no_last_part > $end_index[0]){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Registration No is not in batch range');
                return redirect()->action('Admin\DoctorsCoursesController@edit',[$id])->withInput();
            }
        }
        
        $doctor_course->doctor_id = $request->doctor_id;
        $doctor_course->service_package_id = $request->service_package_id;
        $doctor_course->coming_by_id = $request->coming_by_id;
        $doctor_course->year = $request->year;
        $doctor_course->session_id = $request->session_id;
        $doctor_course->branch_id = $request->branch_id;
        $doctor_course->institute_id = $request->institute_id;
        $doctor_course->course_id = $request->course_id;
        $doctor_course->faculty_id = $request->faculty_id;
        $doctor_course->subject_id = $request->subject_id;
        $doctor_course->batch_id = $request->batch_id;
        $doctor_course->reg_no = $request->reg_no_first_part.$request->reg_no_last_part;
        $doctor_course->reg_no_first_part = $request->reg_no_first_part;
        $doctor_course->reg_no_last_part = $request->reg_no_last_part;
        $doctor_course->payment_status = $request->payment_status;

        $doctor_course->status = $request->status;
        $doctor_course->created_by = Auth::id();        

        $doctor_course->push();

        Session::flash('message', 'Record has been updated successfully');

        return redirect()->action('Admin\DoctorsCoursesController@edit',[$id]);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$user=DoctorsCourses::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

       // DoctorsCourses::destroy($id); // 1 way
        DoctorsCourses::where('id', $id)->update(['is_trash' => 1]);
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\DoctorsCoursesController@index');
    }
    public function doctors_courses_untrash($id)
    {
        /*$user=DoctorsCourses::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        // DoctorsCourses::destroy($id); // 1 way
        DoctorsCourses::where('id', $id)->update(['is_trash' => 0]);
        Session::flash('message', 'Record has been untrash successfully');
        return redirect()->action('Admin\DoctorsCoursesController@index');
    }

    function batch_excel($paras=null)
    {

        session(['paras'=>$paras]);

        $params_array = explode('_',$paras);

        $batch = Batches::where('id',$params_array[2])->value('name');

        $file_name = str_replace(' ', '_', $batch).'_'.$params_array[0];

        return (new UsersExport(1))->download($file_name.'.xlsx');
        //return Excel::download(new UsersExport, 'users.xlsx');
    }



}
