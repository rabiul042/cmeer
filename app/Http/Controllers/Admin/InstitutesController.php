<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Institutes;
use App\Models\Moreinfo;
use Session;
use Auth;
use Validator;


class InstitutesController extends Controller
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
        $institutes = Institutes::get();
        $module_name = 'Institute';
        $title = 'Institutes List';
        $breadcrumb = explode('/',$_SERVER['REQUEST_URI']);
        return view('admin.settings.institute_list',['institutes'=>$institutes,'title'=>$title , 'breadcrumb'=>$breadcrumb, 'module_name'=>$module_name]);
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


        $module_name = 'Institute';
        $title = 'Institute Create';
        $breadcrumb = explode('/',$_SERVER['REQUEST_URI']);
        $submit_value = 'Submit';
        return view('admin.settings.institute_create',(['title'=>$title , 'breadcrumb'=>$breadcrumb,'module_name'=>$module_name,'submit_value'=>$submit_value]));
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
            'type' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            return redirect()->action('Admin\InstitutesController@create')->withInput();
        }

        /*if (Institutes::where('bmdc_no',$request->bmdc_no)->exists()){
            Session::flash('class', 'alert-danger');
            session()->flash('message','This BMDC NO  already exists');
            return redirect()->action('Admin\Settings\InstitutesController@create')->withInput();
        }*/

        $institute = new Institutes();
        $institute->name = $request->name;
        $institute->type = $request->type;
        $institute->status = $request->status;

        $institute->save();

        Session::flash('message', 'Record has been added successfully');

        //return back();

        return redirect()->action('Admin\InstitutesController@index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $institute=Institutes::select('settings.institutes.*')
            ->find($id);
        return view('admin.settings.institutes.show',['institute'=>$institute]);
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

        $institute = Institutes::find($id);

        $module_name = 'Institute';
        $title = 'Institute Edit';
        $breadcrumb = explode('/',$_SERVER['REQUEST_URI']);
        $submit_value = 'Update';


        return view('admin.settings.institute_edit',['institute'=>$institute,'title'=>$title , 'breadcrumb'=>$breadcrumb,'module_name'=>$module_name,'submit_value'=>$submit_value]);
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
            'type' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()){
            Session::flash('class', 'alert-danger');
            return redirect()->action('Admin\Settings\InstitutesController@update')->withInput();
        }

        $institute = Institutes::find($id);
        
        $institute->name = $request->name;
        $institute->type = $request->type;        
        $institute->status = $request->status;

        $institute->push();

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

        Institutes::destroy($id); // 1 way
        Session::flash('message', 'Record has been deleted successfully');
        return redirect()->action('Admin\Settings\InstitutesController@index');
    }





}
