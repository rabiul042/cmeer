<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Notices;
use App\Doctors;
use App\DoctorNotices;
use Illuminate\Http\Request;
use App\Batches;
use App\Models\Moreinfo;
use Session;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Sessions;
use App\Institutes;
use App\Courses;



class NoticeController extends Controller
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
        $data['notices'] = Notices::get();
        return view('admin.notice.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user=Institutes::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        
        $data['title'] = 'Genesis Admin : Notice Create';
        return view('admin.notice.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $notice = new Notices();
        $notice->title = $request->title;
        $notice->notice = $request->notice;

        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = rand(12,98).'_'.time().'.'.$extension;
            $file->move('upload/notice/',$filename);
            $notice->attachment = 'upload/notice/'.$filename;
        }
        else {
            $notice->attachment = '';
        }

        $notice->type = $request->type;
        $notice->year = $request->year;
        $notice->session_id = $request->session_id;
        $notice->institute_id = $request->institute_id;
        $notice->course_id = $request->course_id;
        $notice->batch_id = $request->batch_id;
        $notice->created_by = Auth::id();
        $notice->status = 1;

        $notice->save();

        if ($request->doctor_id) {
            foreach ($request->doctor_id as $k => $value) {
                
                DoctorNotices::insert(['doctor_id' => $value, 'notice_id' => $notice->id]);
            }
        }

        Session::flash('message', 'Record has been added successfully');

        return redirect()->action('Admin\NoticeController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['id'] = $id;
        $notice = Notices::where('id', $id)->first();
        $data['notices'] = Notices::where('id', $id)->first();

        if ($notice->type=='I'){
            $data['doctors'] = DoctorNotices::where('notice_id', $id)->get();
        }

        return view('admin.notice.show', $data);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=Institutes::find(Auth::id());
 
         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/
        //echo $id;exit;
        $data['notice'] = Notices::find($id);

        $data['doctors'] = Doctors::select(DB::raw("CONCAT(name,' - ',bmdc_no) AS full_name"),'id')->orderBy('id', 'DESC')->pluck('full_name', 'id');
        //$data['doctors'] = Doctors::pluck('name', 'id');

        $selected_doctors = DoctorNotices::where('notice_id', $id)->pluck('doctor_id');
        $array_selected_doctor = array();
        foreach($selected_doctors as $doctors){
            $array_selected_doctor[] = $doctors;
        }
        $data['selected_doctors'] = collect($array_selected_doctor);

        $data['years'] = array(''=>'Select year');
        for($year = date("Y")+1;$year>=2019;$year--){$data['years'][$year] = $year;}
        $data['sessions'] = Sessions::get()->pluck('name', 'id');
        $data['institute'] = Institutes::get()->pluck('name', 'id');
        $data['courses'] = Courses::get()->pluck('name', 'id');
        $data['batches'] = Batches::get()->pluck('name', 'id');

        return view('admin.notice.edit', $data);
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
            'title' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            return redirect()->action('Admin\NoticeController@edit')->withInput();
        }

        $notice = Notices::find($id);

        $notice->title = $request->title;
        $notice->notice = $request->notice;

        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = rand(12,98).'_'.time().'.'.$extension;
            $file->move('upload/notice/',$filename);
            $notice->attachment = 'upload/notice/'.$filename;
        }

        $notice->type = $request->type;
        $notice->year = $request->year;
        $notice->session_id = $request->session_id;
        $notice->institute_id = $request->institute_id;
        $notice->course_id = $request->course_id;
        $notice->batch_id = $request->batch_id;
        $notice->created_by = Auth::id();
        $notice->status = $request->status;

        $notice->push();

        if ($request->doctor_id) {
            
            $doctor_notice = DoctorNotices::where('notice_id', $id)->get();
            foreach ($doctor_notice as $k => $doctors) {
                DoctorNotices::destroy($doctors->id);
            }

            foreach ($request->doctor_id as $k => $value) {
                DoctorNotices::insert(['doctor_id' => $value, 'notice_id' => $id]);
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
        /*$user=Institutes::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        Notices::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\NoticeController@index');
    }





}
