<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use Auth;



use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $title = 'Tempore Admin : Dashboard';
        return view('admin.dashboard',['title'=>$title]);
    }




}
