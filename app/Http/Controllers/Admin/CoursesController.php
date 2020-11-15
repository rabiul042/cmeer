<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Courses;
use App\Institutes;
use App\Sessions;
use App\CourseSessions;
use App\Models\Moreinfo;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Validator;


class CoursesController extends Controller
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
        $data['courses'] = Courses::get();
        $data['module_name'] = 'Course';
        $data['title'] = 'Genesis Admin : Courses List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.settings.course_list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user=Courses::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        $data['institute'] = Institutes::get()->pluck('name', 'id');

        $data['sessions'] = Sessions::pluck('name', 'id');


        $data['module_name'] = 'Course';
        $data['title'] = 'Genesis Admin : Course Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.settings.course_create',$data);
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
            'course_code' => ['required'],
            'institute_id' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            return redirect()->action('Admin\CoursesController@create')->withInput();
        }

        if (Courses::where('name',$request->name)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This name  already exists');
            //return back()->withInput();
            return redirect()->action('Admin\CoursesController@create')->withInput();
        }

        if (Courses::where('course_code',$request->course_code)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Course Code  already exists');
            //return back()->withInput();
            return redirect()->action('Admin\CoursesController@create')->withInput();
        }

        $course = new Courses();
        $course->name = $request->name;
        $course->course_code = $request->course_code;
        $course->institute_id = $request->institute_id;
        $course->status = $request->status;
        $course->created_by = Auth::id();        
        $course->save();

        $session_ids = $request->session_id;

        if (is_array($session_ids)) {
            foreach ($session_ids as $key => $value) {
                    
                    if($value == '')continue;
                
                    unset($course_sessions);
                    $course_sessions = new CourseSessions();
                    $course_sessions->course_id = $course->id;
                    $course_sessions->session_id = $value;
                    //$course_sessions->status = $request->status;
                    //$course_sessions->created_by = Auth::id();
                    $course_sessions->save();
                    
            }
        }

        Session::flash('message', 'Record has been added successfully');

        //return back();

        return redirect()->action('Admin\CoursesController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course=Courses::select('settings.courses.*')
            ->find($id);
        return view('admin.settings.courses.show',['course'=>$course]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=Courses::find(Auth::id());
         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/

        $data['course'] = Courses::find($id);
        $data['institutes'] = Institutes::pluck('name', 'id');

        $data['sessions'] = Sessions::pluck('name', 'id');

        //$data['sessions'] = Sessions::pluck('name', 'id');

        $course_sessions = CourseSessions::where('course_id',$id)->pluck('session_id');
        $array_course_sessions = array();
        foreach($course_sessions as $course_session){
            $array_course_sessions[] = $course_session;
        }
        $data['course_sessions'] = collect($array_course_sessions);
        $data['module_name'] = 'Course';
        $data['title'] = 'Course Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';


        return view('admin.settings.course_edit',$data);
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
            'course_code' => ['required'],
            'institute_id' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            return redirect()->action('Admin\CoursesController@edit',[$id])->withInput();
        }

        $course = Courses::find($id);
        
        if($course->name != $request->name){
            if (Courses::where('name',$request->name)->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This name  already exists');
                //return back()->withInput();
                return redirect()->action('Admin\CoursesController@edit',[$id])->withInput();
            }
        }

        if($course->course_code != $request->course_code){
            if (Courses::where('course_code',$request->course_code)->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Course Code  already exists');
                //return back()->withInput();
                return redirect()->action('Admin\CoursesController@edit',[$id])->withInput();
            }
        }

        $course->name = $request->name;
        $course->course_code = $request->course_code;
        $course->institute_id = $request->institute_id;
        $course->status = $request->status;
        $course->updated_by = Auth::id();

        $session_ids = $request->session_id;

        if (is_array($session_ids)) {

            if(CourseSessions::where('course_id',$id)->first()){
                CourseSessions::where('course_id',$id)->delete();
            }

            foreach ($session_ids as $key => $value) {
                    
                    if($value == '')continue;
                
                    unset($course_sessions);
                    $course_sessions = new CourseSessions();
                    $course_sessions->course_id = $course->id;
                    $course_sessions->session_id = $value;
                    //$course_sessions->status = $request->status;
                    //$course_sessions->created_by = Auth::id();
                    $course_sessions->save();
                    
            }
        }
        
        $course->push();

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
        /*$user=Courses::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        Courses::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\CoursesController@index');
    }





}
