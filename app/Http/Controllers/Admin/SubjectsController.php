<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Subjects;
use Illuminate\Http\Request;
use App\Institutes;
use App\Courses;
use App\Faculty;
use App\Faculty_subject;
use App\Question;
use Session;
use Auth;
use Validator;


class SubjectsController extends Controller
{
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

        $subjects = Subjects::get();
        $title = 'Discipline List';
        return view('admin.settings.subject_list',['subjects'=>$subjects,'title'=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user=Questions::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        $institute = Institutes::get()->pluck('name', 'id');

        $title = 'Genesis Admin : Discipline Create';

        return view('admin.settings.subject_create',(['institute'=>$institute,'title'=>$title]));
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
            'subject_omr_code' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return redirect()->action('Admin\SubjectsController@create')->withInput();
        }

        /*if (Subjects::where('name',$request->book_name)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Chapter  already exists');
            return redirect()->action('Admin\QuestionsController@create')->withInput();
        }*/

        $subject = new Subjects();
        $subject->name = $request->name;
        $subject->subject_omr_code = $request->subject_omr_code;
        $subject->institute_id = $request->institute_id;
        $subject->course_id = $request->course_id;
        $subject->faculty_id = $request->faculty_id;

        $subject->status = $request->status;
        $subject->created_by = Auth::id();

        $subject->save();

        Session::flash('message', 'Record has been added successfully');

        //return back();

        return redirect()->action('Admin\SubjectsController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=Questions::select('users.*')
            ->find($id);
        return view('admin.questions.show',['user'=>$user]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=Questions::find(Auth::id());
         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/

        $subject = Subjects::find($id);

        $data['institute'] = Institutes::pluck('name', 'id');

        $data['course'] = Courses::get()->where('institute_id', $subject->institute_id)->pluck('name', 'id');
        $data['faculty'] = Faculty::get()->where('course_id', $subject->course_id)->pluck('name', 'id');
        $data['title'] = 'Discipline Edit';

        return view('admin.settings.subject_edit', ['subject'=>$subject], $data);
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
            'subject_omr_code' => ['required'],
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        /*   if($request->book_name != $question->book_name){
               if (Questions::where('book_name',$request->book_name)->exists()){
                   Session::flash('class', 'alert-danger');
                   session()->flash('message','This Chapter already exists');
                   return redirect()->back()->withInput();
               }
           }*/

        $subject = Subjects::find($id);
        $subject->name=$request->name;
        $subject->subject_omr_code = $request->subject_omr_code;
        $subject->institute_id = $request->institute_id;
        $subject->course_id=$request->course_id;
        $subject->faculty_id=$request->faculty_id;
        $subject->status = $request->status;
        $subject->updated_by = Auth::id();
        $subject->push();
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
        /*$user=Questions::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        Subjects::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\SubjectsController@index');
    }

}
