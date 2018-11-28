<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docu;
use App\RouteInfo;
use Auth;

class PagesController extends Controller
{
    //@TODO ayusing yung mga docus na to temporary lang yung query na to
    public function __construct(){
        $this->middleware('auth')->except('index');
    }


    public function index(){
        return redirect('/login');
    }

    public function accepted(){
        $title = 'Accepted Documents';
        $docus = Docu::orderBy('created_at' , 'desc')
        ->where('is_accepted', '1')
        ->get();
        return view('docus.index', compact('docus', 'title'));
    }

    public function inactive(){
        $title = 'Inactive Documents';
        $docus = Docu::orderBy('created_at' , 'desc')->get();
        // print_r($docus->)
        // $docus = [];
        // $period = \Carbon\CarbonPeriod::between('2000-01-01', '2000-01-15');
        // $weekDayFilter = function($date){
        //     return $date->isWeekday();
        // };
        // $period->filter($weekDayFilter);
        // $days = [];
        // foreach ($period as $date) {
        //     $days[] = $date->format('Y-m-d');
        // }
        // echo implode(', ', $days) . '<br>';
        // echo count($days);
        // die();
        return view('docus.index', compact('docus', 'title'));
    }

    public function receive(){
        $title = 'Received Documents';
        $docus = Docu::join('forsendings', 'docus.id', '=', 'docu_id')
        ->where([
            ['forsendings.receipient_id', Auth::user()->id],
            ['is_accepted', 0]
        ])
        ->orderBy('docus.created_at', 'desc')
        ->get();
        return view('docus.index', compact('docus', 'title'));
    }

    public function soft(){
        $title = 'Soft Deleted Documents';
        $docus = Docu::onlyTrashed()->orderBy('created_at' , 'desc')->get();
        return view('docus.index', compact('docus', 'title'));
    }

    public function getJsonFile(Request $request){
        $routeinfo_id = $request->input('dataID');
        $get_JsonFile_from_routeInfo = RouteInfo::find($routeinfo_id)->upload_data;
        $routeinfoModel = new RouteInfo;
        $html_to_display = $routeinfoModel->FileUploadToView($get_JsonFile_from_routeInfo);
        return response()->json([
            'File_Uploads' => $html_to_display
        ],200);
    }
}
