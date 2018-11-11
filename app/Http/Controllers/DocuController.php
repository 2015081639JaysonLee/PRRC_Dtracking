<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docu;
use App\User;
use App\Forsending;
use App\routeInfo;
use Auth;



class DocuController extends Controller
{   
    /* route info */
    public function routeInfo(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'status' => 'required',
        ]);
        $info = new routeInfo();
        $info->createInfo($request);
        
        return redirect('/docu/' . $request->input('hidden_docuId'))->with('success', 'Route info added!');
    }
    
    /* edit route info */
    public function editRouteInfo(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'status' => 'required',
        ]);
        $info = new routeInfo();
        $info->editInfo($request);

        return redirect('/docu/' . $request->input('hidden_docuId'))->with('success', 'Route info updated!');
    }

    /* forsending */
    public function sendTo(Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required',
            'deadline' => 'required',
        ]);
        
        $sendTo = new Forsending();
        $sendTo->updateForSendRecord($request);

        return redirect('/docu')->with('success', 'Record sent to ' . User::where('id', $request->input('receiver'))->pluck('username')->first());
    }

    /**audit */
    public function audit($docu_id)
        {
            $docuModel = new Docu();
            $output = $docuModel->showAudit($docu_id);
            return view('docus.audit')->with('history', $output);
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
        $docus = Docu::orderBy('created_at' , 'desc')->where('user_id', '=', Auth::user()->id)->get();
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
            'department' => 'required',
            'subject' => 'required',
            'recipient' => 'required',
            'sender_add' => 'required',
            'final_action_date' => 'required',
        ]);

        //Create Docu
            $docu = new Docu;
            $docu_data= $docu->createDocu($request);
            
            $forsending = new Forsending;
            $forsending->newRecordonCreateDocu($docu_data);
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
        // $this->tryCompact();
        $docu = Docu::where('docu_id', '=', $docu_id)->first();
        $userForSendList = User::whereNotIn('id', [Auth::user()->id])->get();   
        $info = routeInfo::orderBy('created_at' , 'desc')->where('docu_id', '=', $docu_id)->paginate(4);
        $editInfoValues = routeInfo::where('docu_id', '=', $docu_id)->latest('id')->first();
        return view('docus.show', compact('docu', 'userForSendList', 'docu_id', 'info', 'editInfoValues'));
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
            'final_action_status' => 'required',
            'final_action_remarks' => 'required',
        ]);

        //Create Docu
            $docu = Docu::where('docu_id' , '=', $docu_id)->first();
            $docu->final_action_stat = $request->input('final_action_status');
            $docu->final_action_remarks = $request->input('final_action_remarks');
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

}
