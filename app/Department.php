<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function docu()
    {
        return $this->hasOne('App\Docu');
    }
}
