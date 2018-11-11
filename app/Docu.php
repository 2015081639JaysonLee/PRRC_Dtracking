<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Http\Request;


class Docu extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    
    
    //Table Name
    protected $table = 'docus';
    //Primary Key
    public $primaryKey = 'docu_id';
    //Timestamps
    public $timestamps = true;

   public function department()
   {
       return $this->belongsTo('App\Department');
   }

   public function forsending()
   {
       return $this->belongsTo('App\Forsending');
   }

   public function showAudit($id)
   {
       $output = $this->find($id)->audits;
       return $output;
   }

   public function createDocu($request)
   {
        $this->subject = $request->input('subject');
        $this->user_id = $request->input('user_id');
        $this->department_id = $request->input('department');
        $this->recipient = $request->input('recipient');
        $this->sender = $request->input('sender');
        $this->sender_add = $request->input('sender_add');
        $this->addressee = $request->input('addressee');
        $this->final_action_date = $request->input('final_action_date');
        $this->save();
        
        $data = [
            'user' => (int)$this->user_id,
            'docu' => $this->docu_id,
        ];

        return $data;
   }

   public function routeinfo()
   {
       return $this->belongsTo('App\RouteInfo');
   }
}


    
       