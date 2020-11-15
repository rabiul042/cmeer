<?php

namespace App\Http\Controllers\Admin;
use App\DoctorsCourses;
use App\Exam;
use App\Http\Controllers\Controller;

use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Doctors;
use App\MedicalColleges;
use App\Divisions;
use App\Districts;
use App\Upazilas;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Validator;
use Yajra\Datatables\Datatables;


class DoctorsController extends Controller
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
        $title = 'Genesis Admin : Doctors List';
        return view('admin.doctors.list',['title'=>$title]);
    }


    public function doctors_list()
    {

        $doctors_list = Doctors::select('*');


        /*$doctors_list = DB::table('doctors as d1')
            ->leftjoin('doctors_courses as d2', 'd2.doctor_id', '=', 'd1.id')
            ->select('d1.*',
                DB::raw("count(d2.doctor_id) AS total_courses"))
            ->groupBy('d1.id')
            ->get();*/

        return Datatables::of($doctors_list)
            ->addColumn('action', function ($doctors_list) {
                return view('admin.doctors.ajax_list',(['doctors_list'=>$doctors_list]));
            })

            ->addColumn('total_course', function ($doctors_list) {
                return $doctors_list->doctorcourses->count();
            })

            ->addColumn('status', function ($doctors_list) {
                return ($doctors_list->status==1)?'Active':'InActive' ;
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
        // $user=Doctors::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        $medical_colleges = MedicalColleges::get()->pluck('name', 'id');
        $divisions = Divisions::get()->pluck('name', 'id');


        $title = 'SIF Admin : Doctor Create';
        return view('admin.doctors.create',(['title'=>$title,'medical_colleges'=>$medical_colleges,'divisions'=>$divisions]));
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
            'bmdc_no' => ['required'],
            'mobile_number' => ['required'],
            'email' => ['required'],
            /*'date_of_birth' => ['required'],*/
            //'medical_college_id' => ['required'],
            //'gender' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\DoctorsController@create')->withInput();
        }

        if (Doctors::where('bmdc_no',$request->bmdc_no)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This BMDC NO  already exists');
            return redirect()->action('Admin\DoctorsController@create')->withInput();
        }

        else{

            $doctor = new Doctors();
            $doctor->name = $request->name;
            $doctor->bmdc_no = $request->bmdc_no;
            $doctor->mobile_number = $request->mobile_number;
            $doctor->main_password = $pass=rand(123456, 987654);
            $doctor->password = Hash::make($pass);
            $doctor->email = $request->email;
            $doctor->date_of_birth = $request->date_of_birth;
            $doctor->gender = $request->gender;
            $doctor->father_name = $request->father_name;
            $doctor->mother_name = $request->mother_name;
            $doctor->spouse_name = $request->spouse_name;
            $doctor->medical_college_id = $request->medical_college_id;
            $doctor->chamber_address = $request->chamber_address;
            $doctor->blood_group = $request->blood_group;
            $doctor->facebook_id = $request->facebook_id;
            $doctor->job_description = $request->job_description;
            $doctor->nid = $request->nid;
            $doctor->passport = $request->passport;
            $doctor->permanent_division_id = $request->permanent_division_id;
            $doctor->permanent_district_id = $request->permanent_district_id;
            $doctor->permanent_upazila_id = $request->permanent_upazila_id;
            $doctor->permanent_address = $request->permanent_address;
            $doctor->present_division_id = $request->present_division_id;
            $doctor->present_district_id = $request->present_district_id;
            $doctor->present_upazila_id = $request->present_upazila_id;
            $doctor->present_address = $request->present_address;
            $doctor->status = $request->status;
            $doctor->created_by = Auth::id();
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $filename = $doctor->bmdc_no.'_'.time().'.'.$extension;
                $file->move('upload/photo/',$filename);
                $doctor->photo = 'upload/photo/'.$filename;
            }
            else {
                $doctor->photo = '';
            }
            if($request->hasFile('sign')){
                $file = $request->file('sign');
                $extension = $file->getClientOriginalExtension();
                $filename = $doctor->bmdc_no.'_'.time().'.'.$extension;
                $file->move('upload/photo/',$filename);
                $doctor->sign = 'upload/photo/'.$filename;
            }
            else {
                $doctor->sign = '';
            }

            $doctor->save();

            Session::flash('message', 'Record has been added successfully');

            //return back();

            return redirect()->action('Admin\DoctorsController@index');
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
        
      $data['doctor'] = Doctors::select('doctors.*')->find($id);
      return view('admin.doctors.show',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=Doctors::find(Auth::id());

         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/

        $doctor=Doctors::find($id);

        $medical_colleges = MedicalColleges::get()->pluck('name', 'id');

        $permanent_divisions = Divisions::get()->pluck('name', 'id');

        $permanent_districts = Districts::get()->where('division_id',$doctor->permanent_division_id)->pluck('name', 'id');
        $permanent_upazilas = Upazilas::get()->where('district_id',$doctor->permanent_district_id)->pluck('name', 'id');

        $present_divisions = Divisions::get()->pluck('name', 'id');

        $present_districts = Districts::get()->where('division_id',$doctor->present_division_id)->pluck('name', 'id');
        $present_upazilas = Upazilas::get()->where('district_id',$doctor->present_district_id)->pluck('name', 'id');

        $title = 'SIF Admin : Doctor Edit';

        $array_data = array(
            'doctor'=>$doctor,
            'title'=>$title,
            'medical_colleges'=>$medical_colleges,
            'permanent_divisions'=>$permanent_divisions,
            'permanent_districts'=>$permanent_districts,
            'permanent_upazilas'=>$permanent_upazilas,
            'present_divisions'=>$present_divisions,
            'present_districts'=>$present_districts,
            'present_upazilas'=>$present_upazilas,

        );

        return view('admin.doctors.edit', $array_data);
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
            'bmdc_no' => ['required'],
            'mobile_number' => ['required'],
            'email' => ['required'],
            /*'date_of_birth' => ['required'],*/
            //'medical_college_id' => ['required'],
            //'gender' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter proper input values!!!');
            return redirect()->action('Admin\DoctorsController@edit',[$id])->withInput();
        }

        $doctor = Doctors::find($id);

        $doctor->name = $request->name;
        $doctor->bmdc_no = $request->bmdc_no;
        $doctor->main_password = $request->password;
        $doctor->password = Hash::make($request->password);
        $doctor->mobile_number = $request->mobile_number;
        $doctor->email = $request->email;
        $doctor->date_of_birth = $request->date_of_birth;
        $doctor->gender = $request->gender;
        $doctor->father_name = $request->father_name;
        $doctor->mother_name = $request->mother_name;
        $doctor->spouse_name = $request->spouse_name;
        $doctor->medical_college_id = $request->medical_college_id;
        $doctor->chamber_address = $request->chamber_address;
        $doctor->blood_group = $request->blood_group;
        $doctor->facebook_id = $request->facebook_id;
        $doctor->job_description = $request->job_description;
        $doctor->nid = $request->nid;
        $doctor->passport = $request->passport;
        $doctor->permanent_division_id = $request->permanent_division_id;
        $doctor->permanent_district_id = $request->permanent_district_id;
        $doctor->permanent_upazila_id = $request->permanent_upazila_id;
        $doctor->permanent_address = $request->permanent_address;
        $doctor->present_division_id = $request->present_division_id;
        $doctor->present_district_id = $request->present_district_id;
        $doctor->present_upazila_id = $request->present_upazila_id;
        $doctor->present_address = $request->present_address;
        $doctor->status = $request->status;

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = $doctor->bmdc_no.'_'.time().'.'.$extension;
            $file->move('upload/photo/',$filename);
            $doctor->photo = 'upload/photo/'.$filename;
        }
        else {
            $doctor->photo = '';
        }
        if($request->hasFile('sign')){
            $file = $request->file('sign');
            $extension = $file->getClientOriginalExtension();
            $filename = $doctor->bmdc_no.'_'.time().'.'.$extension;
            $file->move('upload/photo/',$filename);
            $doctor->sign = 'upload/photo/'.$filename;
        }
        else {
            $doctor->sign = '';
        }

        $doctor->push();

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
        /*$user=Doctors::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        Doctors::destroy($id); // 1 way
        //Doctors::where('id', $id)->update(['is_trash' => 1]);
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\DoctorsController@index');
    }

    public function view_course_result($id)
    {

        $data['course_id'] = $id;

        $data['course_reg_no'] = DoctorsCourses::select('*')->where('id', $id)->first();
        $data['results'] = Result::select('*')->where('doctor_course_id', $id)->get();
        return view('admin.doctors.course_result', $data);

    }



}