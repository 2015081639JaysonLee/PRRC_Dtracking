<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docu;

class PagesController extends Controller
{
    public function index(){
        
        $title = 'Welcome To Laravel!';
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function intransit(){
        $title = "In Transit Documents";
        return view('pages.intransit')->with('title', $title);
    }

    public function archived(){
        /*$data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.services')->with($data);
         }*/
        $title = "Archived Documents";
        return view('pages.archived')->with('title', $title); 
    }
}
