<?php

namespace App\Http\Controllers;

use App\Coming_by;
use App\ComingBy;
use App\Http\Controllers\Controller;

use App\MedicalColleges;
use Illuminate\Http\Request;

use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Subjects;
use App\Batches;
use App\Branch;
use App\Doctors;
use App\Sessions;
use App\BatchDisciplineFee;
use App\ServicePackages;
use App\DoctorsCourses;
use Session;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;  
use App\BatchesSchedules;

class DoctorsAdmissionsController extends Controller
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
        $this->middleware('auth:doctor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['doctors_courses'] = DoctorsCourses::where('doctor_id',Auth::id())->get();
        $data['title'] = 'SIF Doctor : Doctors Courses List';
        return view('doctors_courses.list',$data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctor_admissions()
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            //$data['years'][$year] = $year;
        }
        $data['years'][date("Y")] = date("Y");
        $data['title'] = 'SIF Doctor : Doctor Courses Create';
        $data['branches'] = Branch::pluck('name', 'id');
        $data['institutes'] = Institutes::get()->pluck('name', 'id');
        $data['sessions'] = Sessions::get()->pluck('name', 'id');
        return view('doctor_admissions',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doctor_admission_submit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'year' => ['required'],
            'session_id' => ['required'],
            'branch_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'subject_id' => ['required'],
            'batch_id' => ['required'],
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('DoctorsAdmissionsController@doctor_admission_submit')->withInput();
        }        

        $doctor_course = new DoctorsCourses();
        $doctor_course->doctor_id =  Auth::id();
        $doctor_course->year = $request->year;
        $doctor_course->branch_id = $request->branch_id;
        $doctor_course->session_id = $request->session_id;
        $doctor_course->institute_id = $request->institute_id;
        $doctor_course->course_id = $request->course_id;
        $doctor_course->faculty_id = $request->faculty_id;
        $doctor_course->subject_id = $request->subject_id;
        $doctor_course->batch_id = $request->batch_id;

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

        $start_index = Batches::where('id',$request->batch_id)->pluck('start_index');
        $end_index = Batches::where('id',$request->batch_id)->pluck('end_index');

        if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
        {
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Batch does not exist in the selected Branch !!!');
            return redirect()->action('DoctorsAdmissionsController@doctor_admissions')->withInput();
        }

        if (DoctorsCourses::where(['doctor_id'=>Auth::id(),'year'=>$request->year,'session_id'=>$request->session_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id,'is_trash'=>'0'])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Dear doctor, you are already filled admission form or registered for this course!!!');
            return redirect()->action('DoctorsAdmissionsController@doctor_admissions')->withInput();
        }

        if ($request->reg_no_last_part < $start_index[0] ||  $request->reg_no_last_part > $end_index[0]){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Registration No is not in batch range');
            return redirect()->action('DoctorsAdmissionsController@doctor_admissions')->withInput();
        }
        
        if($request->t_id > 0){

            DoctorsCourses::where(['id'=>$request->t_id])->update([
                'doctor_id'=>Auth::id(),
                'faculty_id' => $doctor_course->faculty_id,
                'subject_id' => $doctor_course->subject_id,
                'course_price' => $doctor_course->course_price,
                'payment_status' => $doctor_course->payment_status,
                'is_trash'=>'0',
                'status'=>'1',
                ]);
            $doctor_course_update = DoctorsCourses::where(['id'=>$request->t_id])->get();
            DoctorsCourses::where(['id'=>$request->t_id])->update(['created_at'=>$doctor_course_update->updated_at,'created_at'=>$doctor_course_update->updated_at]);
        }
        else 
        {

            if(DoctorsCourses::where(['reg_no_first_part'=>$request->reg_no_first_part, 'reg_no_last_part'=>$request->reg_no_last_part])->exists()){

                Session::flash('class', 'alert-danger');
                session()->flash('message','This Registration No already exists');
                return redirect()->action('DoctorsAdmissionsController@doctor_admissions')->withInput();
            }        
    
            $doctor_course->save();
            DoctorsCourses::where(['id'=>$doctor_course->id])->update(['created_at'=>$doctor_course->created_at]);
            
        }
        

        Session::flash('status', 'Record has been added successfully');

        //return back();

        return redirect('payment-details');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_doctor_course_discipline($doctor_course_id)
    {
        $data['doc_info'] = Doctors::where('id', Auth::id())->first();
        $data['doctor_course'] = DoctorsCourses::where('id',$doctor_course_id)->first();
        $doctor_course = $data['doctor_course'];

        //echo '<pre>';print_r($doctor_course);exit;

        $data['institutes'] = Institutes::get()->pluck('name', 'id');

        $data['courses'] = Courses::where('institute_id',$doctor_course->course->institute->id)->pluck('name', 'id');

        $data['institute_type'] = Institutes::where('id',$doctor_course->institute_id)->first()->type;

        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$doctor_course->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$doctor_course->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$doctor_course->course_id)->pluck('name', 'id');
        }

        $data['title'] = 'SIF Doctor : Doctor Courses Descipline Edit';


        return view('edit_doctor_course_discipline',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_doctor_course_discipline(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'doctor_course_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('DoctorsAdmissionsController@edit_doctor_course_discipline',[$request->doctor_course_id])->withInput();
        }

        $doctor_course = DoctorsCourses::find($request->doctor_course_id);
        $doctor_course->institute_id = $request->institute_id;
        $doctor_course->course_id = $request->course_id;
        $doctor_course->faculty_id = $request->faculty_id;
        $doctor_course->subject_id = $request->subject_id;
        $doctor_course->is_discipline_changed = '1';

        $doctor_course->updated_by = Auth::id();

        $doctor_course->push();

        Session::flash('message', 'Record has been updated successfully');

        return redirect()->action('DoctorsAdmissionsController@edit_doctor_course_discipline',[$request->doctor_course_id]);



    }







    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=DoctorsCourses::find(Auth::id());

         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/


         $data['years'] = array(''=>'Select year');
         for($year = date("Y")+1;$year>=2017;$year--){
             $data['years'][$year] = $year;
         }
 
         $doctor_course = DoctorsCourses::find($id);
 
         //echo "<pre>";print_r($doctor_course);exit;
 
         $data['title'] = 'SIF Doctor : Doctors Courses Edit';
         $data['doctor'] = Doctors::where('id',$doctor_course->doctor_id)->first();
         $data['doctor_course'] = $doctor_course;
         $data['sessions'] = Sessions::get()->pluck('name', 'id');
         $data['service_packages'] = ServicePackages::get()->pluck('name', 'id');
         $data['coming_bys'] = ComingBy::get()->pluck('name', 'id');
         $data['branches'] = Branch::pluck('name', 'id');
         $data['institutes'] = Institutes::get()->pluck('name', 'id');
 
         $institute_type = Institutes::where('id',$doctor_course->institute_id)->first()->type;
         Session(['institute_type'=> $institute_type]);
         //$data['url']  = ($institute_type)?'branches-courses-faculties-batches':'branches-courses-subjects-batches';
         $data['url']  = ($institute_type)?'course-sessions-faculties':'course-sessions-subjects';
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
 
        return view('doctors_courses.edit', $data);
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
            //'reg_no_last_part' => ['required'],
            //'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('DoctorsCoursesController@edit',[$id])->withInput();
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
                return redirect()->action('DoctorsCoursesController@edit',[$id])->withInput();

            }

        }

        if($doctor_course->doctor_id != $request->doctor_id || $doctor_course->year != $request->year || $doctor_course->session_id != $request->session_id || $doctor_course->institute_id != $request->institute_id || $doctor_course->course_id != $request->course_id){
            
            if (DoctorsCourses::where(['doctor_id'=>$request->doctor_id,'year'=>$request->year,'session_id'=>$request->session_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','Dear doctor, you are already filled admission form or registered for this course!!!');
                return redirect()->action('DoctorsCoursesController@edit',[$id])->withInput();
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
        //$doctor_course->reg_no = $request->reg_no_first_part.$request->reg_no_last_part;
        $doctor_course->reg_no_first_part = $request->reg_no_first_part;
        //$doctor_course->reg_no_last_part = $request->reg_no_last_part;

        $doctor_course->status = $request->status;
        $doctor_course->created_by = Auth::id();        

        $doctor_course->push();

        Session::flash('message', 'Record has been updated successfully');

        return redirect()->action('DoctorsCoursesController@edit',[$id]);

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

        //DoctorsCourses::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('DoctorsCoursesController@index');
    }

}
