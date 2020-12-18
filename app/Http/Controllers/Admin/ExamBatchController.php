<?php
namespace App\Http\Controllers\Admin;
use App\ExamBatch;
use App\ExamBatchExam;
use App\Http\Controllers\Controller;
use App\Exam;
use App\Sessions;
use Illuminate\Http\Request;
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


class ExamBatchController extends Controller
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
        $data['exam_batches'] = ExamBatch::get();
        $data['module_name'] = 'Exam Batch';
        $data['title'] = 'Exam Batch List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.exam_batch.list',$data);

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

        $data['exams'] = Exam::pluck('name', 'id');



        $data['module_name'] = 'Exam Batch';
        $data['title'] = 'Exam Batch Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.exam_batch.create',$data);
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
            'exam_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\ExamBatchController@create')->withInput();
        }

        if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
        {
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Batch does not exist in the selected Branch !!!');
            return redirect()->action('Admin\ExamBatchController@create')->withInput();

        }

        if (ExamBatch::where(['year'=>$request->year,'session_id'=>$request->session_id,'branch_id'=>$request->branch_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This link already exists for the batch');
            return redirect()->action('Admin\ExamBatchController@create')->withInput();
        }
        else{

            $exam_batch = new ExamBatch();

            $exam_batch->year = $request->year;
            $exam_batch->session_id = $request->session_id;
            $exam_batch->branch_id=$request->branch_id;
            $exam_batch->institute_id=$request->institute_id;
            $exam_batch->course_id=$request->course_id;
            $exam_batch->faculty_id=$request->faculty_id;
            $exam_batch->subject_id=$request->subject_id;
            $exam_batch->batch_id=$request->batch_id;
            $exam_batch->status=$request->status;
            $exam_batch->created_by=Auth::id();
            $exam_batch->save();


            $exam_ids = $request->exam_id;

            if (is_array($exam_ids)) {
                foreach ($exam_ids as $key => $value) {

                    if($value == '')continue;

                    unset($exam_batch_exam);
                    $exam_batch_exam = new ExamBatchExam();
                    $exam_batch_exam->exam_batch_id = $exam_batch->id;
                    $exam_batch_exam->exam_id = $value;
                    //$exam_batch_exam->status = $request->status;
                    //$exam_batch_exam->created_by = Auth::id();
                    $exam_batch_exam->save();

                }
            }

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\ExamBatchController@index');
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
        $exam_batch=ExamBatch::select('exam_batchs.*')->find($id);
        return view('admin.exam_batch.show',['exam_batch'=>$exam_batch]);
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
        $exam_batch = ExamBatch::find($id);
        $data['exam_batch'] = ExamBatch::find($id);

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2017;$year--){
            $data['years'][$year] = $year;
        }

        $data['sessions'] = Sessions::pluck('name', 'id');
        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['exams'] = Exam::pluck('name', 'id');

        $data['branches'] = Branch::pluck('name','id');
        $institute_type = Institutes::where('id',$exam_batch->institute_id)->first()->type;
        Session(['institute_type'=> $institute_type]);
        $data['url']  = ($institute_type)?'courses-faculties-topics-batches-lectures':'courses-subjects-topics-batches-lectures';
        $data['institute_type']= $institute_type;

        $data['courses'] = Courses::where('institute_id',$exam_batch->institute_id)->pluck('name', 'id');

        if($data['institute_type']==1){
            $data['faculties'] = Faculty::where('course_id',$exam_batch->course_id)->pluck('name', 'id');
            $data['subjects'] = Subjects::where('faculty_id',$exam_batch->faculty_id)->pluck('name', 'id');
        }else{
            $data['subjects'] = Subjects::where('course_id',$exam_batch->course_id)->pluck('name', 'id');
        }

        $data['batches'] = Batches::where('institute_id',$exam_batch->institute_id)
            ->where('course_id',$exam_batch->course_id)
            ->where('branch_id',$exam_batch->branch_id)
            ->pluck('name', 'id');


        $data['exams'] = Exam::pluck('name', 'id');

        $selected_exams = array();
        foreach($exam_batch->exams as $exam)
        {
            $selected_exams[] = $exam->exam_id;
        }


        $data['selected_exams'] = collect($selected_exams);


        $data['exams'] = Exam::pluck('name', 'id');


        $data['module_name'] = 'Exam Batch';
        $data['title'] = 'Exam Batch Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.exam_batch.edit', $data);

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
            'exam_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        $exam_batch = ExamBatch::find($id);

        if($exam_batch->branch_id != $request->branch_id)
        {
            if(Batches::where(['branch_id'=>$request->branch_id,'id'=>$request->batch_id])->first() === null)
            {
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Batch does not exist in the selected Branch !!!');
                return redirect()->action('Admin\ExamBatchController@edit',[$id])->withInput();

            }

        }

        if($exam_batch->year != $request->year || $exam_batch->session_id != $request->session_id || $exam_batch->branch_id != $request->branch_id || $exam_batch->institute_id != $request->institute_id || $exam_batch->course_id != $request->course_id || $exam_batch->batch_id != $request->batch_id) {

            if (ExamBatch::where(['year'=>$request->year,'session_id'=>$request->session_id,'branch_id'=>$request->branch_id,'institute_id'=>$request->institute_id,'course_id'=>$request->course_id,'batch_id'=>$request->batch_id])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Lecture Address already exists for the batch');
                return redirect()->action('Admin\ExamBatchController@edit',[$id])->withInput();
            }

        }

        $exam_batch->year = $request->year;
        $exam_batch->session_id = $request->session_id;
        $exam_batch->branch_id=$request->branch_id;
        $exam_batch->institute_id=$request->institute_id;
        $exam_batch->course_id=$request->course_id;
        $exam_batch->faculty_id=$request->faculty_id;
        $exam_batch->subject_id=$request->subject_id;
        $exam_batch->batch_id=$request->batch_id;
        $exam_batch->status=$request->status;
        $exam_batch->updated_by=Auth::id();
        $exam_batch->push();


        $exam_ids = $request->exam_id;

        if(ExamBatchExam::where('exam_batch_id',$exam_batch->id)->first())
        {
            ExamBatchExam::where('exam_batch_id',$exam_batch->id)->delete();
        }

        if (is_array($exam_ids)) {

            foreach ($exam_ids as $key => $value) {

                if($value == '')continue;

                unset($exam_batch_exam);
                $exam_batch_exam = new ExamBatchExam();
                $exam_batch_exam->exam_batch_id = $exam_batch->id;
                $exam_batch_exam->exam_id = $value;
                //$exam_batch_exam->status = $request->status;
                //$exam_batch_exam->created_by = Auth::id();
                $exam_batch_exam->save();

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
        ExamBatch::destroy($id); // 1 way
        ExamBatchExam::where('exam_batch_id',$id)->delete(); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\ExamBatchController@index');
    }
}