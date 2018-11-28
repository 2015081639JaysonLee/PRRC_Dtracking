<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Forsending extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    //Table Name
    protected $table = 'forsendings';
    //Primary Key
    public $primaryKey = 'send_id';

    public function docu()
    {
        return $this->belongsTo('App\Docu');
    }

    public function newRecordonCreateDocu($request, $route_data)
    {   
        $date_with_seconds = $request->input('final_action_date') .' 17:0:0';
        $receiver_id = User::where('username', $request->input('recipient'))->pluck('id')->first();
        $this->docu_id = $route_data['docu'];
        $this->sender = $request->input('sender');
        $this->receipient_id = $receiver_id;
        $this->date_deadline = $date_with_seconds;
        $this->routeinfo_id = $route_data['routeinfo'];
        $this->save();
    }

    public function updateForSendRecord($request)
    {        
        $date_with_seconds = $request->input('deadline') .' 17:0:0';
        $record_to_update = $this->whereDocu_id($request->input('hidden_docuId'))->first();
        $record_to_update->sender = $request->input('hidden_sender');
        $record_to_update->receipient_id = User::where('username', $request->input('receiver'))->pluck('id')->first();
        $record_to_update->date_deadline = $date_with_seconds;
        $record_to_update->routeinfo_id = $request->input('hidden_routeinfoID');
        $record_to_update->save();
    }
}
