<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Question;
use App\Question_ans;

use Session;
use Auth;
use Validator;
use Yajra\DataTables\DataTables;


class SbaController extends Controller
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
        $title = 'SBA Question';
        return view('admin.sba.list',['title'=>$title]);
        //echo "OK";
    }


    public function sba_list()
    {
        $sba_list = Question::where('type', 2)->orderBy('id', 'desc')->select('*');

        return Datatables::of($sba_list)
            ->addColumn('action', function ($sba_list) {
                return view('admin.sba.ajax_list',(['sba_list'=>$sba_list]));
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
       // $user=Questions::find(Auth::id());

        /*if(!$user->hasRole('Admin')){
            return abort(404);
        }*/
        
        $title = 'SBA Question Create';

        return view('admin.sba.create', (['title'=>$title]));
           
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
            'question_title' => ['required'],
            'question_a' => ['required'],
            'question_b' => ['required'],
            'question_c' => ['required'],
            'question_d' => ['required'],
            'question_e' => ['required'],
            'correct_ans' => ['required'],
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            Session::flash('message', "Please enter valid Data");
            return redirect()->action('Admin\SbaController@create')->withInput();
        }

        /*if (Questions::where('book_name',$request->book_name)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This Chapter  already exists');
            return redirect()->action('Admin\QuestionsController@create')->withInput();
        }*/

            $question = new Question;
            $question->question_title = $request->question_title;
            $question->type = 2;
            $question->correct_ans = $request->correct_ans;
            $question->discussion = $request->discussion;
            $question->reference = $request->reference;
            $question->status = 1;
            $question->created_by = Auth::id();
            $question->save();

            $question_id = $question->id;

            $answer = new Question_ans; $answer->question_id = $question_id; $answer->answer = $request->question_a; $answer->sl_no = 'A'; $answer->save();
            $answer = new Question_ans; $answer->question_id = $question_id; $answer->answer = $request->question_b; $answer->sl_no = 'B'; $answer->save();
            $answer = new Question_ans; $answer->question_id = $question_id; $answer->answer = $request->question_c; $answer->sl_no = 'C'; $answer->save();
            $answer = new Question_ans; $answer->question_id = $question_id; $answer->answer = $request->question_d; $answer->sl_no = 'D'; $answer->save();
            $answer = new Question_ans; $answer->question_id = $question_id; $answer->answer = $request->question_e; $answer->sl_no = 'E'; $answer->save();


            Session::flash('message', 'Record has been added successfully');

            //return back();

            return redirect()->action('Admin\SbaController@index');

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
        return view('admin.sba.show',['user'=>$user]);
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


        $questions = Question::find($id);
        $title = 'SBA Question Edit';
        return view('admin.sba.edit',['questions'=>$questions, 'title'=>$title]);
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
            'question_title' => ['required'],
            'question_a' => ['required'],
            'question_b' => ['required'],
            'question_c' => ['required'],
            'question_d' => ['required'],
            'question_e' => ['required'],
            'correct_ans' => ['required']
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

        $question = Question::find($id);
        $question->question_title=$request->question_title;
        $question->correct_ans=$request->correct_ans;
        $question->discussion=$request->discussion;
        $question->reference=$request->reference;
        $question->push();

        $qa_id = $request->qa_id; $question_ans = Question_ans::find($qa_id); $question_ans->answer=$request->question_a; $question_ans->push();
        $qb_id = $request->qb_id; $question_ans = Question_ans::find($qb_id); $question_ans->answer=$request->question_b; $question_ans->push();
        $qc_id = $request->qc_id; $question_ans = Question_ans::find($qc_id); $question_ans->answer=$request->question_c; $question_ans->push();
        $qd_id = $request->qd_id; $question_ans = Question_ans::find($qd_id); $question_ans->answer=$request->question_d; $question_ans->push();
        $qe_id = $request->qe_id; $question_ans = Question_ans::find($qe_id); $question_ans->answer=$request->question_e; $question_ans->push();

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

        Question::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\SbaController@index');
    }





}
