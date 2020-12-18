<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DoctorsCourses;
use App\ExamAssignLink;
use App\Exam;
use App\ExamAssign;
use App\ExamDiscipline;
use App\ExamFaculty;
use App\ExamAssignBatchExamAssign;
use App\Sessions;
use Illuminate\Http\Request;
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


class ExamAssignController extends Controller
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
        $data['exam_assigns'] = ExamAssign::get();
        $data['module_name'] = 'Exam Assign';
        $data['title'] = 'Exam Assign List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.exam_assign.list',$data);
                
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

        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['exams'] = Exam::where(['sif_only'=>'No'])->pluck('name', 'id');

        $data['module_name'] = 'Exam Assign';
        $data['title'] = 'Exam Assign Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.exam_assign.create',$data);
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
            'exam_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],    
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\ExamAssignController@create')->withInput();
        }        

        if (ExamAssign::where(['exam_id'=>$request->exam_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id])->first()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Exam assignment already exists');
            return redirect()->action('Admin\ExamAssignController@create')->withInput();
        }
        else{

            $exam_assign = new ExamAssign();
            $exam_assign->exam_id = $request->exam_id;
            $exam_assign->institute_id = $request->institute_id;
            $exam_assign->course_id = $request->course_id;
            $exam_assign->status=$request->status;
            $exam_assign->created_by=Auth::id();
            $exam_assign->save();

            $institute = Institutes::where('id',$request->institute_id)->first();

            if($institute->type == 1)
            {
                if (ExamFaculty::where('exam_assign_id', $exam_assign->id)->first()) {
                    ExamFaculty::where('exam_assign_id', $exam_assign->id)->delete();
                }

                if($request->faculty_id)
                {
                    foreach ($request->faculty_id as $key => $value) {
                        if($value=='')continue;
                        ExamFaculty::insert(['exam_assign_id' => $exam_assign->id,'exam_id' => $exam_assign->exam_id, 'faculty_id' => $value]);
                    }
                }

            }
            else
            {

                if (ExamDiscipline::where('exam_assign_id', $exam_assign->id)->first()) {
                    ExamDiscipline::where('exam_assign_id', $exam_assign->id)->delete();
                }

                if($request->subject_id)
                {
                    foreach ($request->subject_id as $key => $value) {
                        if($value=='')continue;
                        ExamDiscipline::insert(['exam_assign_id' => $exam_assign->id,'exam_id' => $exam_assign->exam_id, 'subject_id' => $value]);
                    }
                }

            }

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\ExamAssignController@index');
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
        $exam_assign=ExamAssign::select('exam_assigns.*')->find($id);
        return view('admin.exam_assign.show',['exam_assign'=>$exam_assign]);
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
        $exam_assign = ExamAssign::find($id);
        $data['exam_assign'] = ExamAssign::find($id);
        $data['institutes'] = Institutes::pluck('name', 'id');
        $data['exams'] = Exam::where(['sif_only'=>'No'])->pluck('name', 'id');
        
        $institute = Institutes::where('id',$exam_assign->institute_id)->first();
        if($institute)$institute_type = $institute->type;
        else $institute_type = null;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'courses-faculties':'courses-subjects';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::where('institute_id',$exam_assign->institute_id)->pluck('name', 'id');
        
        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$exam_assign->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$exam_assign->faculty_id)->pluck('name', 'id');

            $exam_assign_faculties = ExamFaculty::where('exam_assign_id',$id)->get();
            $selected_faculties = array();
            foreach($exam_assign_faculties as $faculty)
            {
                $selected_faculties[] = $faculty->faculty_id;
            }

            $data['selected_faculties'] = collect($selected_faculties);

        }else{
            $data['subjects'] = Subjects::where('course_id',$exam_assign->course_id)->pluck('name', 'id');

            $exam_assign_disciplines = ExamDiscipline::where('exam_assign_id',$id)->get();
            $selected_subjects = array();
            foreach($exam_assign_disciplines as $exam_assign_discipline)
            {
                $selected_subjects[] = $exam_assign_discipline->subject_id;
            }

            $data['selected_subjects'] = collect($selected_subjects);
        }

        $data['module_name'] = 'Exam Assign';
        $data['title'] = 'Exam Assign Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.exam_assign.edit', $data);
        
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
            'exam_id' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
        
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return redirect()->action('Admin\ExamAssignController@edit',[$id])->withInput();
        }

        $exam_assign = ExamAssign::find($id);

        if($exam_assign->exam_id != $request->exam_id || $exam_assign->institute_id != $request->institute_id || $exam_assign->course_id != $request->course_id) {

            if (ExamAssign::where(['exam_id'=>$request->exam_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id])->first()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Exam assignment already exists');
                return redirect()->action('Admin\ExamAssignController@edit',[$id])->withInput();
            }

        }

        $exam_assign->exam_id = $request->exam_id;
        $exam_assign->institute_id = $request->institute_id;
        $exam_assign->course_id = $request->course_id;
        $exam_assign->status=$request->status;
        $exam_assign->updated_by=Auth::id();
        $exam_assign->push();

        $institute = Institutes::where('id',$request->institute_id)->first();

        if($institute->type == 1)
        {
            if (ExamFaculty::where('exam_assign_id', $exam_assign->id)->first()) {
                ExamFaculty::where('exam_assign_id', $exam_assign->id)->delete();
            }

            if($request->faculty_id)
            {
                foreach ($request->faculty_id as $key => $value) {
                    if($value=='')continue;
                    ExamFaculty::insert(['exam_assign_id' => $exam_assign->id,'exam_id' => $exam_assign->exam_id, 'faculty_id' => $value]);
                }
            }

        }
        else
        {

            if (ExamDiscipline::where('exam_assign_id', $exam_assign->id)->first()) {
                ExamDiscipline::where('exam_assign_id', $exam_assign->id)->delete();
            }

            if($request->subject_id)
            {
                foreach ($request->subject_id as $key => $value) {
                    if($value=='')continue;
                    ExamDiscipline::insert(['exam_assign_id' => $exam_assign->id,'exam_id' => $exam_assign->exam_id, 'subject_id' => $value]);
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
        ExamAssign::destroy($id); // 1 way
        if (ExamFaculty::where('exam_assign_id', $id)->first()) {
            ExamFaculty::where('exam_assign_id', $id)->delete();
        }
        if (ExamDiscipline::where('exam_assign_id', $id)->first()) {
            ExamDiscipline::where('exam_assign_id', $id)->delete();
        }
        
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\ExamAssignController@index');
    }

    public function download_emails($id){

        $exam_assign = ExamAssign::find($id);
        $emails = array();

        foreach($exam_assign->batches as $batch){
            unset($exam_assign_batch_id);
            $lecture_link = ExamAssignLink::where('id',$batch->exam_assign_batch_id)->get()[0];
            unset($doctors_courses);
            $doctors_courses = DoctorsCourses::where(['year'=>$lecture_link->year,'session_id'=>$lecture_link->session_id,'institute_id'=>$lecture_link->institute_id,'course_id'=>$lecture_link->course_id,'batch_id'=>$lecture_link->batch_id])->get();
            
            foreach($doctors_courses as $doctor_course){
                $emails[] = $doctor_course->doctor->email;
            }
        }

        $content = implode(',',$emails);
        $file_name = $exam_assign->name.'.csv';
        $headers = [
                        'Content-type'        => 'text/csv',
                        'Content-Disposition' => 'attachment; filename='.$file_name,
                ];
            
        return Response::make($content, 200, $headers);
        
    }
}  