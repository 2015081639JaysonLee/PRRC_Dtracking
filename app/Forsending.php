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
        return $this->hasOne('App\Docu');
    }

    public function newRecordonCreateDocu($docu_data)
    {
        $this->docu_id = $docu_data['docu'];
        $this->sender_id = $docu_data['user'];
        $this->receiver_id = (string)$docu_data['user'];
        $this->save();
    }

    public function updateForSendRecord($request)
    {
        $this->where('docu_id',  $request->input('hidden_docuId'))
        ->update([
            'sender_id' => $request->input('hidden_senderId'),
            'receiver_id' => $request->input('receiver'),
            'date_deadline' => $request->input('deadline')
        ]);
    }
}
