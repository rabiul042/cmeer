<?php

namespace App\Http\Controllers\Admin;
use App\Courses;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Faculty;
use App\Institutes;
use App\Couses;
use Session;
use Auth;
use Validator;


class FacultyController extends Controller
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

        $faculty = Faculty::get();
        $title = 'Genesis Admin : Faculty List';
        return view('admin.settings.faculty_list',['faculty'=>$faculty,'title'=>$title]);
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
        $institute = institutes::where('type', 1)->get()->pluck('name', 'id');
        $title = 'Genesis Admin : Faculty Create';
        return view('admin.settings.faculty_create', (['institute'=>$institute,'title'=>$title]));
        
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
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'name' => ['required'],
            'faculty_omr_code' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data.");
            return redirect()->action('Admin\FacultyController@create')->withInput();
        }



        /*if (Questions::where('book_name',$request->book_name)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Chapter  already exists');
            return redirect()->action('Admin\QuestionsController@create')->withInput();
        }*/

            $faculty = new Faculty;
            $faculty->institute_id = $request->institute_id;
            $faculty->course_id = $request->course_id;
            $faculty->faculty_omr_code = $request->faculty_omr_code;
            $faculty->name = $request->name;
            $faculty->status = 1;
            $faculty->created_by = Auth::id();

            $faculty->save();

            Session::flash('message', 'Record has been added successfully');

            //return back();

            return redirect()->action('Admin\FacultyController@index');

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

        $faculty = Faculty::find($id);
        $data['institute'] = Institutes::where('type', 1)->pluck('name', 'id');
        $data['course'] = Courses::get()->where('institute_id', $faculty->institute_id)->pluck('name', 'id');
        $data['title'] = 'Faculty Edit';
        return view('admin.settings.faculty_edit', ['faculty'=>$faculty], $data);
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
            'institute_id' => ['required'],
            'course_id' => ['required'],
            'faculty_omr_code' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data.");
            return back()->withInput();
        }

     /*   if($request->book_name != $question->book_name){
            if (Questions::where('book_name',$request->book_name)->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Chapter already exists');
                return redirect()->back()->withInput();
            }
        }*/

        $faculty = Faculty::find($id);
        $faculty->institute_id = $request->institute_id;
        $faculty->course_id=$request->course_id;
        $faculty->faculty_omr_code = $request->faculty_omr_code;
        $faculty->name=$request->name;
        $faculty->push();
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
        /*$user=Faculty::find($id);

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        Faculty::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\FacultyController@index');
    }





}
