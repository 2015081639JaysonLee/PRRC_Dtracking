<?php

namespace App\Http\Controllers;
use App\Docu;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docus = Docu::orderBy('created_at' , 'desc')->where('username', '=', Auth::user()->username)->paginate(10);
        return view('docus.index')->with('docus', $docus);
       
    }

    

}
