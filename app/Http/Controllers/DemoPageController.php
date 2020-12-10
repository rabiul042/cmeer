<?php

namespace App\Http\Controllers;

use Auth;
use App\DoctorEducations;
use App\Doctors;
use App\Divisions;
use App\MedicalColleges;
use Illuminate\Http\Request;

class DemoPageController extends Controller
{
    function index(){
        $data['medical_colleges'] = MedicalColleges::orderBy('name')->pluck('name','id');
        $data['medical_colleges_name'] = MedicalColleges::orderBy('name')->pluck('name','name');
        $data['divisions'] = Divisions::get()->pluck('name', 'id');
        return view('demo_page',$data);
    }
    function register_first_step_submit(Request $request){

        $request->validate([
            'name' => 'required',
            'bmdc_no' => 'required|unique:doctors',
            'mobile_number' => 'required|unique:doctors',
            'email' => 'required|unique:doctors',
            'password' => 'required|min:6',
            'medical_college_id' => 'required',
        ]);

        $doctor = new Doctors();
        $doctor->name = $request->name;
        $doctor->bmdc_no = $request->bmdc_no;
        $doctor->mobile_number = $request->mobile_number;
        $doctor->email = $request->email;
        $doctor->main_password = $request->password;
        $doctor->medical_college_id = $request->medical_college_id;
        $doctor->password = bcrypt($request->password);
        // $doctor->father_name = $request->father_name;
        // $doctor->mother_name = $request->mother_name;
        // $doctor->date_of_birth = $request->date_of_birth;
        // $doctor->gender = $request->gender;
        // $doctor->nid = $request->nid;
        // $doctor->job_description = $request->job_description;
        // $doctor->present_division_id = $request->present_division_id;
        // $doctor->present_district_id = $request->present_district_id;
        // $doctor->present_upazila_id = $request->present_upazila_id;
        // $doctor->present_address = $request->present_address;
        // $doctor->permanent_division_id = $request->permanent_division_id;
        // $doctor->permanent_district_id = $request->permanent_district_id;
        // $doctor->permanent_upazila_id = $request->permanent_upazila_id;
        // $doctor->permanent_address = $request->permanent_address;

        // if ($request->file('image')){
        //     $file=$request->file('image');
        //     $fileName = md5(uniqid(rand(), true)).'.'.strtolower(pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION)) ;
        //     $destinationPath = 'store/' ;
        //     $file->move($destinationPath,$fileName);
        //     $doctor->photo = $destinationPath.$fileName;
        // }

        $doctor->save();

        // foreach($request->exam as $k => $value){
        //     if($request->board[$k]==''){
        //         continue;
        //     }

        //     $doctors_education =new DoctorEducations();
        //     $doctors_education->exam = $value;
        //     $doctors_education->board = $request->board[$k];
        //     $doctors_education->result = $request->result[$k]??'';
        //     $doctors_education->passing_year = $request->year[$k]??'';
        //     $doctors_education->roll = $request->roll[$k]??'';
        //     $doctors_education->duration = $request->duration[$k]??'';
        //     $doctors_education->doctor_id = $doctor->id;
        //     $doctors_education->save();
        // }

        Auth::guard('doctor')->loginUsingId($doctor->id);
        return redirect('my-profile');

    }
    // function register_second_step($id){

    //     $data['divisions'] = Divisions::get()->pluck('name', 'id');
    //     return view('registration_second',$data,['id'=>$id]);
        
    // }
    // function register_second_step_submit(Request $request){
        
        

    //     $doctor = Doctors::find($request->id);;
    //     $doctor->father_name = $request->father_name;
    //     $doctor->mother_name = $request->mother_name;
    //     $doctor->date_of_birth = $request->date_of_birth;
    //     $doctor->gender = $request->gender;
    //     $doctor->nid = $request->nid;
    //     $doctor->job_description = $request->job_description;
    //     $doctor->present_division_id = $request->present_division_id;
    //     $doctor->present_district_id = $request->present_district_id;
    //     $doctor->present_upazila_id = $request->present_upazila_id;
    //     $doctor->present_address = $request->present_address;
    //     $doctor->permanent_division_id = $request->permanent_division_id;
    //     $doctor->permanent_district_id = $request->permanent_district_id;
    //     $doctor->permanent_upazila_id = $request->permanent_upazila_id;
    //     $doctor->permanent_address = $request->permanent_address;



    //     $doctor->save();

    //     return redirect('register-third-step/'.$doctor->id);  

    // }
    // function register_third_step($id){
    //     $data['id']=$id;
    //     $data['doctors_education'] = DoctorEducations::where('doctor_id', '=', $id)->get();
    //     $data['medical_colleges'] = MedicalColleges::orderBy('name')->pluck('name','id');

    //     return view('registration_third',$data);
        
    // }
    // function register_third_step_submit(Request $request){

    //     $doctors_education =new DoctorEducations();
        
    //     if($request->board){
    //         $doctors_education->board = $request->board;
    //     }elseif($request->medical_college_id){
    //         $medi = MedicalColleges::find($request->medical_college_id);
    //         $doctors_education->board = $medi->name;
    //     }
        
    //     $doctors_education->exam = $request->exam;
    //     $doctors_education->result = $request->result;
    //     $doctors_education->passing_year = $request->year;
    //     $doctors_education->roll = $request->roll;
    //     $doctors_education->duration = $request->duration;
    //     $doctors_education->doctor_id = $request->id;


    //     $doctors_education->save();
    //     return redirect('register-third-step/'.$request->id);
    // }


}   
   
