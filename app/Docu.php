<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;


class Docu extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    //Table Name
    protected $table = 'docus';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $dates = ['deleted_at'];

   public function department()
   {
       return $this->belongsTo('App\Department');
   }

   public function forsending()
   {
       return $this->hasOne('App\Forsending');
   }

   public function user()
   {
       return $this->belongsTo('App\User');
   }

   public function restore_docu($request)
   {
       $docu_to_restore = $this->onlyTrashed()->find($request->input('hidden_docuId'));
       $docu_to_restore->restore();
   }

   public function accept_docu($request)
   {
        $docu_to_approve = $this->find($request->input('hidden_docuId'));
        $docu_to_approve->is_accepted = 1;
        $docu_to_approve->save();
   }

   public function createDocu($request)
   {
        $date_with_seconds = \Carbon\Carbon::parse($request->input('final_action_date') .' 17:0:0')->format('Y-m-d G:i:s');
        $this->department_id = $request->input('department');
        $this->user_id = $request->input('user_id');
        $this->subject = $request->input('subject');
        $this->recipient = $request->input('recipient');
        $this->addressee = $request->input('addressee');
        $this->sender = $request->input('sender');
        $this->sender_add = $request->input('sender_add');
        $this->final_action_date = $date_with_seconds;
        $this->is_rush = $request->input('rushed');
        $this->iso_code = $request->input('iso');
        $this->location = $request->input('location');
        $this->save();
        
        $outData = [
            'user' => (int)$this->user_id,
            'docu' => (int)$this->id,
        ];

        return $outData;
   }

   public function updateDocu($request, $docu_id)
   {
    $date_with_seconds = \Carbon\Carbon::parse($request->input('final_action_date') .' 17:0:0')->format('Y-m-d G:i:s');
        $docu_to_update = $this->whereId($docu_id)->first();
        $docu_to_update->subject = $request->input('subject');
        $docu_to_update->department_id = $request->input('department');
        $docu_to_update->is_rush = $request->input('rushed');
        $docu_to_update->location = $request->input('location');
        $docu_to_update->iso_code = $request->input('iso');
        $docu_to_update->final_action_date = $date_with_seconds;
        $docu_to_update->save();
   }

   public function routeinfo()
   {
       return $this->hasMany('App\RouteInfo');
   }
}


    
       