<?php

namespace App\Http\Controllers;

use App\Page;
use App\Result;
use Illuminate\Http\Request;
use App\Doctors;
use App\DoctorsCourses;
use Session;
use Validator;
use Auth;



class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:doctor');
    }

    public function aboutus()
    {
        $data['title'] = Page::where('id',1)->value('title');
        $data['description'] = Page::where('id',1)->value('description');
        return view('aboutus',$data);
    }

    public function successstories()
    {

        $data['title'] = Page::where('id',2)->value('title');
        $data['description'] = Page::where('id',2)->value('description');
        return view('successstories', $data);
    }

    public function contactus()
    {
        $data['title'] = Page::where('id',3)->value('title');
        $data['description'] = Page::where('id',3)->value('description');
        return view('contactus',$data);
    }

    public function faq()
    {
        $data['title'] = Page::where('id',4)->value('title');
        $data['description'] = Page::where('id',4)->value('description');
        return view('faq',$data);
    }


    public function course_result($id)
    {
        $data['course_reg_no'] = DoctorsCourses::select('*')->where('id', $id)->first();
        $data['course_id'] = $id;
        $data['exam'] = Result::where('doctor_course_id', $id)->first();
        $results = Result::select('*')->where('doctor_course_id', $id)->get();
        foreach ($results as $row){
            $row->overall_position = Result::select('id')->where('exam_id',$row->exam_id)->where('obtained_mark_decimal','>=',$row->obtained_mark_decimal)->groupBy('obtained_mark_decimal')->get();
            $row->subject_position = Result::select('id')->where('exam_id',$row->exam_id)->where('subject_id',$row->subject_id)->where('obtained_mark_decimal','>=',$row->obtained_mark_decimal)->groupBy('obtained_mark_decimal')->get();
            $row->batch_position = Result::select('id')->where('exam_id',$row->exam_id)->where('batch_id',$row->batch_id)->where('obtained_mark_decimal','>=',$row->obtained_mark_decimal)->groupBy('obtained_mark_decimal')->get();
            $row->candidate_position = Result::select('id')->where('exam_id',$row->exam_id)->where('candidate_code',$row->candidate_code)->where('obtained_mark_decimal','>=',$row->obtained_mark_decimal)->groupBy('obtained_mark_decimal')->get();
            $row->exam_highest = Result::where('exam_id',$row->exam_id)->orderBy('obtained_mark','desc')->value('obtained_mark');
        }
        //dd($results);
        $data['results'] = $results;

        return view('course_result', $data);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:11|unique:doctors',
            'email' => 'required|string|email|max:255|unique:doctors',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', 'Dear doctor, Please input proper values!!!');
            return redirect('register')->withErrors($validator)->withInput();
        }


        $doctor = new Doctors();
        $doctor->name=$request->name;
        $doctor->email=$request->email;
        $doctor->mobile_number = $request->mobile_number;
        $doctor->main_password=$request->password;
        $doctor->password= bcrypt($request->password);
        $doctor->save();

        Auth::loginUsingId($doctor->id);
        return redirect('my-profile');

    }

    
}
