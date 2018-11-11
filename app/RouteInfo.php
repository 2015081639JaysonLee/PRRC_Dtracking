<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RouteInfo extends Model
{
    public function docu()
    {
        return $this->hasMany('App/Docu');
    }

    public function createInfo($request)
    {
        $this->edited_by = $request->input('editedBy');
        $this->docu_id = $request->input('hidden_docuId');
        $this->status = $request->input('status');
        $this->remarks = $request->input('remarks');
        $this->save();
    }

    public function editInfo($request){
        $this->where('id', $request->input('hidden_routeinfoID'))
        ->update([
            'status' => $request->input('status'),
            'remarks' => $request->input('remarks')
        ]);
    }
}
