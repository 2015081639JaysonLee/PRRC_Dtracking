<?php

namespace App\Http\Controllers;
use App\Docu;

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
        $title = "All Documents";
        $docus = Docu::orderBy('created_at' , 'desc')->get();
        return view('docus.index', compact('docus', 'title'));
    }

    

}
