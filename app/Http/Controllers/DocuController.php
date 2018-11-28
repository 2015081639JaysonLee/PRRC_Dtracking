<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docu;
use App\User;
use App\Forsending;
use App\routeInfo;
use App\Statuscode;
use App\Department;
use DB;
use Auth;



class DocuController extends Controller
{   
    protected $statuses;
    protected $department;
    protected $user;
    protected $routeInfo;
    protected $docu;
    protected $forsending;

    // restoring of docu
    public function restore(Request $request)
    {
        $this->docu->restore_docu($request);

        $request->session()->flash('success', 'Document restored!');

        return redirect('/docu/' . $request->input('hidden_docuId'));
    }

    // approval of docu
    public function approve(Request $request)
    {
        $this->docu->accept_docu($request);

        $request->session()->flash('success', 'Record finalized and accepted!');

        return redirect('/docu/' . $request->input('hidden_docuId'));
    }

    /* route info */
    public function routeInfo(Request $request)
    {
        $this->validate($request, [
            'remarks' => 'required',
            'statuscode' => 'required',
            'filename' => 'nullable|array',
            'filename.*' => 'nullable|mimes:jpeg,bmp,png,pptx,pdf,docx|max:50000',
        ]);
        $info = new routeInfo();
        $info->createInfo($request, null);
        
        $request->session()->flash('success', 'Route info added!');

        return redirect('/docu/' . $request->input('hidden_docuId'));
    }
    
    /* edit route info */
    public function editRouteInfo(Request $request)
    {
        $this->validate($request, [
            'remarks' => 'required',
            'statuscode' => 'required',
            'filename' => 'nullable|array',
            'filename.*' => 'nullable|mimes:jpeg,bmp,png,pptx,pdf,docx|max:50000',
        ]);
        $info = new routeInfo();
        $info->editInfo($request);
        
        $request->session()->flash('success', 'Route info edited!');

        return redirect('/docu/' . $request->input('hidden_docuId'));
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

        return redirect('/docu')->with('success', 'Record sent to ' . User::where('username', $request->input('receiver'))->pluck('username')->first());
    }

    /**audit */
    public function audit($docu_id)
        {
            $route_history = $this->forsending->whereDocu_id($docu_id)->first()->audits;
            return view('docus.audit', compact('route_history'));
        }
            
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Statuscode $statuses, Department $department, User $user,
    routeInfo $routeInfo, Docu $docu, Forsending $forsending)
    {
        $this->middleware('auth');
        $this->department = $department;
        $this->statuses = $statuses;
        $this->user = $user;
        $this->routeInfo = $routeInfo;
        $this->docu = $docu;
        $this->forsending = $forsending;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $title = 'My Documents';
        $docus = Docu::orderBy('created_at' , 'desc')->where('user_id', '=', Auth::user()->id)->get();
        return view('docus.index', compact('docus', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $department_list = $this->department->pluck('name', 'id');
        $status_list = $this->statuses->pluck('status','id');
        $user_not_including_the_current_user = $this->user->whereNotIn('id', [Auth::user()->id])->pluck('username');
        return view('docus.create', compact('status_list', 'department_list', 'user_not_including_the_current_user'));
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
            'rushed' => 'required',
            'location' => 'required',
            'department' => 'required',
            'subject' => 'required',
            'sender' => 'required',
            'recipient' => 'required',
            'statuscode' => 'required',
            'remarks' => 'required',
            'filename' => 'nullable|array',
            'filename.*' => 'nullable|mimes:jpeg,bmp,png,pptx,pdf,docx|max:50000',
            'final_action_date' => 'required',
        ]);
        DB::transaction(function() use ($request) {
            $docu_data= $this->docu->createDocu($request);

            $route_data = $this->routeInfo->createInfo($request, $docu_data);

            $this->forsending->newRecordonCreateDocu($request, $route_data);

            $request->session()->flash('success', 'Document Created');
        });

        return redirect('/docu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function show($docu_id)
    {
        $docu_to_be_shown = $this->docu->withTrashed()->findOrFail($docu_id);
        $userForSendList = $this->user->whereNotIn('id', [Auth::user()->id])->get();   
        $all_routeinfo_of_docu = $this->routeInfo->orderBy('created_at' , 'desc')->whereDocu_id($docu_id)->paginate(5);
        $editInfoValues = $this->routeInfo->whereDocu_id($docu_id)->latest('id')->first();
        $forsendId = $this->forsending->whereDocu_id($docu_id)->pluck('receipient_id')->first();
        $status_list = $this->statuses->pluck('status','id');

        return view('docus.show', compact('docu_to_be_shown', 'userForSendList', 'docu_id', 'all_routeinfo_of_docu', 
        'editInfoValues', 'forsendId', 'status_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($docu_id)
    {
        $department_list = $this->department->pluck('name', 'id');
        $docu_to_edit = $this->docu->withTrashed()->where('id', $docu_id)->first();
        return view('docus.edit', compact('docu_to_edit', 'department_list'));
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
            'rushed' => 'required',
            'location' => 'required',
            'department' => 'required',
            'subject' => 'required',
            'final_action_date' => 'required',
        ]);
        
        $docu = new Docu;
        $docu->updateDocu($request, $docu_id);
        return redirect('/docu/' . $docu_id)->with('success', 'Document Updated');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $docu_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $docu_id)
    {
        $docu = $this->docu->withTrashed()->whereId($docu_id)->first();    
        if($docu->deleted_at == null){
            $docu->delete();
            $request->session()->flash('success', 'Record soft deleted');
        }        
        else{
            $docu->forsending()->delete();
            $docu->routeinfo()->delete();
            $docu->forceDelete();
            $request->session()->flash('success', 'Record permenantly deleted');
        }
        return redirect('/soft');
    }

}