<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\QuestionTypes;
use App\MedicalColleges;
use App\Divisions;
use App\Districts;
use App\Upazilas;
use Session;
use Auth;
use Validator;
use Yajra\Datatables\Datatables;


class QuestionTypesController  extends Controller
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
        $question_types = QuestionTypes::get();

        $title = 'Question Type List';

        return view('admin.question_types.list', ['question_types'=>$question_types, 'title'=>$title]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user=QuestionTypes ::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        $title = 'Question Type Create';
        return view('admin.question_types.create',(['title'=>$title]));
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
            'title' => ['required'],
            'mcq_number' => ['required'],
            'mcq_mark' => ['required'],
            'sba_number' => ['required'],
            'sba_mark' => ['required'],
            //'negative_mark' => ['required'],
            //'full_mark' => ['required'],
            'duration' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','Please enter valid data!!!');
            return redirect()->action('Admin\QuestionTypesController@create')->withInput();
        }

        if (QuestionTypes::where('title', $request->title)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Question Type Title already exists');
            return redirect()->action('Admin\QuestionTypesController@create')->withInput();
        }

        else{

            $question_type = new QuestionTypes ();
            $question_type->title = $request->title;
            $question_type->mcq_number = $request->mcq_number;
            $question_type->mcq_mark = $request->mcq_mark;
            $question_type->mcq_negative_mark = $request->mcq_negative_mark;
            $question_type->sba_number = $request->sba_number;
            $question_type->sba_mark = $request->sba_mark;
            $question_type->sba_negative_mark = $request->sba_negative_mark;
            $mcq = $request->mcq_number*$request->mcq_mark;
            $sba = $request->sba_number*$request->sba_mark;
            $question_type->full_mark = $mcq+$sba;
            $question_type->pass_mark = $request->pass_mark;
            $question_type->duration = $request->duration*60;
            $question_type->paper_faculty = $request->paper_faculty;
            $question_type->status = 1;
            $question_type->save();

            Session::flash('message', 'Record has been added successfully');
            return redirect()->action('Admin\QuestionTypesController@index');
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
        $user=QuestionTypes ::select('question_types.*')
            ->find($id);
        return view('admin.question_types.show',['user'=>$user]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /* $user=QuestionTypes ::find(Auth::id());

         if(!$user->hasRole('Admin')){
             return abort(404);
         }*/

        $data['type_info'] = QuestionTypes::find($id);
        $data['duration'] = $data['type_info']->duration/60;
        $data['title'] = "Edit Question Type";
        return view('admin.question_types.edit', $data);
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
            'title' => ['required'],
            'mcq_number' => ['required'],
            'mcq_mark' => ['required'],
            'sba_number' => ['required'],
            'sba_mark' => ['required'],
            //'negative_mark' => ['required'],
            //'full_mark' => ['required'],
            'duration' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', 'Validation Failed !!! Redirected to Edit Page');
            return redirect()->action('Admin\QuestionTypesController@edit',[$id])->withInput();
        }

        $question_type = QuestionTypes::find($id);

        $question_type->title = $request->title;
        $question_type->mcq_number = $request->mcq_number;
        $question_type->mcq_mark = $request->mcq_mark;
        $question_type->mcq_negative_mark = $request->mcq_negative_mark;
        $question_type->sba_number = $request->sba_number;
        $question_type->sba_mark = $request->sba_mark;
        $question_type->sba_negative_mark = $request->sba_negative_mark;
        $mcq = $request->mcq_number*$request->mcq_mark;
        $sba = $request->sba_number*$request->sba_mark;
        $question_type->full_mark = $mcq+$sba;
        $question_type->pass_mark = $request->pass_mark;
        $question_type->duration = $request->duration*60;
        $question_type->paper_faculty = $request->paper_faculty;

        
        $question_type->push();

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
        /*$user=QuestionTypes ::find(Auth::id());

        if(!$user->hasRole('Admin')){
            return abort(404);
        }*/

        QuestionTypes ::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\QuestionTypesController@index');
    }





}
