<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docu;
use Auth;



class DocuController extends Controller
{

    /**audit */
    public function audit(Docu $docu)
        {
            $diff = $docu->audits()->with('username')->get()->last();

            return view('docus.audit')
                ->withPost($docu)
                ->withDiff($diff);
        }
            
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* to order the display */
        //$docu = Docu::orderBy('created_date' , 'desc')->get();
       // $docus = Docu::all();
        
        $docus = Docu::orderBy('created_at' , 'desc')->where('username', '=', Auth::user()->username)->paginate(10);
        return view('docus.index')->with('docus', $docus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('docus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'subject' => 'required',
            'recipient' => 'required',
            'sender_add' => 'required',
            'final_action_stat' => 'required',
            'final_action_remarks' => 'required',
            'final_action_date' => 'required',
            'final_action_by' => 'required'
        ]);

        //Create Docu
            $docu = new Docu;
            $docu->subject = $request->input('subject');
            $docu->username = $request->input('username');
            $docu->recipient = $request->input('recipient');
            $docu->sender = $request->input('sender');
            $docu->sender_add = $request->input('sender_add');
            $docu->addressee = $request->input('addressee');
            $docu->cc_addressee = $request->input('cc_addressee');
            $docu->final_action_stat = $request->input('final_action_stat');
            $docu->final_action_remarks = $request->input('final_action_remarks');
            $docu->final_action_date = $request->input('final_action_date');
            $docu->final_action_by = $request->input('final_action_by');
            $docu->save();

            return redirect('/docu')->with('success', 'Document Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function show($docu_id)
    {
        
        $docu = Docu::where('docu_id', '=', $docu_id)->first();
        return view('docus.show')->with('docu', $docu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($docu_id)
    {
        $docu = Docu::where('docu_id', '=', $docu_id)->first();
        return view('docus.edit')->with('docu', $docu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $docu_id)
    {
        $this->validate($request,[
            'subject' => 'required',
            'recipient' => 'required',
            'sender_add' => 'required',
            'final_action_stat' => 'required',
            'final_action_remarks' => 'required',
            'final_action_date' => 'required',
            'final_action_by' => 'required'
        ]);

        //Create Docu
            $docu = Docu::where('docu_id' , '=', $docu_id)->first()->where('username', '=', Auth::user()->username);
            $docu->subject = $request->input('subject');
            $docu->recipient = $request->input('recipient');
            $docu->sender = $request->input('sender');
            $docu->sender_add = $request->input('sender_add');
            $docu->addressee = $request->input('addressee');
            $docu->cc_addressee = $request->input('cc_addressee');
            $docu->final_action_stat = $request->input('final_action_stat');
            $docu->final_action_remarks = $request->input('final_action_remarks');
            $docu->final_action_date = $request->input('final_action_date');
            $docu->final_action_by = $request->input('final_action_by');
            $docu->save();

            return redirect('/docu')->with('success', 'Document Updated');
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($docu_id)
    {
        $docu = Docu::where('docu_id', '=', $docu_id)->first();

             
        $docu->delete();
        return redirect('/docu')->with('success', 'Document Removed');
    }

    public function searchcontent(){


        $searchkey = \Request::get('title');
        $docus =  Docu::where('subject', 'like', '%' .$searchkey. '%')
                        ->orWhere('id', 'like', '%'.$searchkey.'%')
                        ->orWhere('recipient', 'like', '%'.$searchkey.'%')
                        ->orWhere('sender', 'like', '%'.$searchkey.'%')
                        ->orWhere('final_action_stat', 'like', '%'.$searchkey.'%')
                        ->orderBy('id')->paginate(10);

        return view('searchcontent', ['docus' => $docus]);
    }
}
