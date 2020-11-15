<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Topics;
use App\Courses;
use Session;
use Auth;
use Validator;


class TopicController extends Controller
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
        $Topics = Topics::get();
        $title = 'Class/ChapterList';
        return view('admin.topic.list',['topics'=>$Topics,'title'=>$title]);
        
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
        

        $courses = Courses::get()->pluck('name', 'id');


        $title = 'Class/ChapterCreate';

        return view('admin.topic.create',(['courses'=>$courses,'title'=>$title]));
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
            'course_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter valid data!!!');
            return redirect()->action('Admin\TopicController@create')->withInput();
        }


        
  

        if (Topics::where('name',$request->topic_name)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Class/Chapter already exists');
            return redirect()->action('Admin\TopicController@create')->withInput();
        }
    
        


        $topic = new Topics;
        $topic->name=$request->name;
        $topic->course_id=$request->course_id;
        $topic->status=1;
        $topic->created_by=Auth::id();
        $topic->save();

        Session::flash('message', 'Record has been added successfully');

        return redirect()->action('Admin\TopicController@index');
        
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
        $topic=Topics::find($id);
        $course = Courses::get()->pluck('name', 'id');
        $title = 'Tempore Admin : Class/ChapterEdit';
        return view('admin.topic.edit',['course'=>$course, 'topic'=>$topic, 'title'=>$title]);
        
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
            'course_id' => ['required']
        ]);
        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }
        
    //    $subject=Subjects::find($id);
    //    if($request->book_name != $subject->book_name){
    //        if (Subjects::where('book_name',$request->book_name)->exists()){
    //            Session::flash('class', 'alert-danger');
    //            session()->flash('message','This Subject already exists');
    //            return redirect()->back()->withInput();
    //        }
    //    }

        $topic=Topics::find($id);

        if($request->name != $topic->name){
            if (Topics::where('name',$request->name)->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Class/Chapteralready exists');
                return redirect()->back()->withInput();
            }
        }
        
        $topic->name=$request->name;
        $topic->course_id=$request->course_id;
        $topic->push();
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

       /* if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        Topics::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\TopicController@index');
    }
}
