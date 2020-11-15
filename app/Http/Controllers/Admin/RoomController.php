<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\OnlineLectureAddress;
use App\Room;
use App\Sessions;
use Illuminate\Http\Request;
use App\Exam;
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


class RoomController extends Controller
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
        $data['rooms'] = Room::get();
        $data['module_name'] = 'Room';
        $data['title'] = 'Room List';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);

        return view('admin.room.list',$data);
                
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

        $data['module_name'] = 'Room';
        $data['title'] = 'Room Create';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Submit';

        return view('admin.room.create',$data);
        
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

            'room_name' => ['required'],
            'Location' => ['required'],
            'floor' => ['required'],
            'capacity' => ['required'],

        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\RoomController@create')->withInput();
        }

        if (Room::where(['room_name'=>$request->room_name,'Location'=>$request->Location])->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Room already exists in this Location');
            return redirect()->action('Admin\RoomController@create')->withInput();
        }
        else{

            $room = new Room();
            $room->room_name = $request->room_name;
            $room->Location = $request->Location;
            $room->floor = $request->floor;
            $room->capacity = $request->capacity;
            $room->status=$request->status;
            $room->created_by=Auth::id();
            $room->save();

            Session::flash('message', 'Record has been added successfully');

            return redirect()->action('Admin\RoomController@index');
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
        $room=Room::select('rooms.*')->find($id);
        return view('admin.room.show',['room'=>$room]);
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
        
        $data['room'] = Room::find($id);

        $data['module_name'] = 'Room';
        $data['title'] = 'Room Edit';
        $data['breadcrumb'] = explode('/',$_SERVER['REQUEST_URI']);
        $data['submit_value'] = 'Update';
        return view('admin.room.edit', $data);
        
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
            'room_name' => ['required'],
            'Location' => ['required'],
            'floor' => ['required'],
            'capacity' => ['required'],
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return back()->withInput();
        }

        $room = Room::find($id);

        if($room->room_name != $request->room_name || $room->Location != $request->Location) {

            if (Room::where(['room_name'=>$request->room_name,'Location'=>$request->Location])->exists()){
                Session::flash('class', 'alert-danger');
                session()->flash('message','This Room already exists in this Location');
                return redirect()->action('Admin\RoomController@edit',[$id])->withInput();
            }

        }

        $room->room_name = $request->room_name;
        $room->Location = $request->Location;
        $room->floor = $request->floor;
        $room->capacity = $request->capacity;
        $room->status=$request->status;
        $room->updated_by=Auth::id();
        $room->push();
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
        Room::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\RoomController@index');
    }
}